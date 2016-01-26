<?php
	/**
	 * 对mysql敏感字符串转义
	 *
	 * @access  public
	 * @param   string      $str
	 *
	 * @return string
	 */
	function dump_escape_string($str)
	{
		return Import::db_mysql()->escape($str);
	}
	
	/**
	 * 对mysql记录中的null值进行处理
	 *
	 * @access  public
	 * @param   string      $str
	 *
	 * @return string
	 */
	function dump_null_string($str)
	{
		if (!isset($str) || is_null($str))
		{
			$str = 'NULL';
		}
	
		return $str;
	}
		
//数据库备份与导入类
class Backdb{

	var $max_size  = 2097152; // 2M
    var $is_short  = false;
    var $offset    = 300;
    var $dump_sql  = '';
    var $sql_num   = 0;
    var $error_msg = '';

    var $db;
	
	function  setdbboj($dbs=array()) {
		$this->db = $dbs;
	}
	/**
	 * 对 MYSQL LIKE 的内容进行转义
	 *
	 * @access      public
	 * @param       string      string  内容
	 * @return      string
	 */
	function mysql_like_quote($str)
	{
		return strtr($str, array("\\\\" => "\\\\\\\\", '_' => '\_', '%' => '\%', "\'" => "\\\\\'"));
	}
	
	/**
	 *  将含有单位的数字转成字节
	 *
	 * @access  public
	 * @param   string      $val        带单位的数字
	 *
	 * @return  int         $val
	 */
	function return_bytes($val)
	{
		$val = trim($val);
		$last = strtolower($val{strlen($val)-1});
		switch($last)
		{
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}
	
		return $val;
	}
	
	    /**
		 *  返回一个随机的名字
		 *
		 * @access  public
		 * @param
		 *
		 * @return      string      $str    随机名称
		 */
		function get_random_name()
		{
			$str = date('Ymd');
	
			for ($i = 0; $i < 6; $i++)
			{
				$str .= chr(mt_rand(97, 122));
			}
	
			return $str;
		}
		
		 /**
		 *  将数据表数组写入指定文件
		 *
		 * @access  public
		 * @param   string      $path    文件路径
		 * @param   array       $arr    要写入的数据
		 *
		 * @return  boolen
		 */
		function put_tables_list($path, $arr)
		{
			if (is_array($arr))
			{
				$str = '';
				foreach($arr as $key => $val)
				{
					$str .= $key . ':' . $val . ";\r\n";
				}

				if (@file_put_contents($path, $str))
				{
					return true;
				}
				else
				{
					$this->error_msg = 'Can not write ' . $path;
	
					return false;
				}
			}
			else
			{
				$this->error_msg = 'It need a array';
	
				return false;
			}
		}
		
		 /**
		 *  将文件中数据表列表取出
		 *
		 * @access  public
		 * @param   string      $path    文件路径
		 *
		 * @return  array       $arr    数据表列表
		 */
		function get_tables_list($path)
		{
			if (!file_exists($path))
			{
				$this->error_msg = $path . ' is not exists';
	
				return false;
			}
	
			$arr = array();
			$str = @file_get_contents($path);
	
			if (!empty($str))
			{
				$tmp_arr = explode("\n", $str);
				foreach ($tmp_arr as $val)
				{
					$val = trim ($val, "\r;");
					if (!empty($val))
					{
						list($table, $count) = explode(':',$val);
						$arr[$table] = $count;
					}
				}
			}

			return $arr;
		}
		 /**
		 *  备份一个数据表
		 *
		 * @access  public
		 * @param   string      $path       保存路径表名的文件
		 * @param   int         $vol        卷标
		 *
		 * @return  array       $tables     未备份完的表列表
		 */
		function dump_table($path, $vol)
		{
			$tables = $this->get_tables_list($path);
	
			if ($tables === false)
			{
				return false;
			}
	
			if (empty($tables))
			{
				return $tables;
			}
	
			$this->dump_sql = $this->make_head($vol);
	
			foreach($tables as $table => $pos)
			{ 
	
				if ($pos == -1)
				{
					/* 获取表定义，如果没有超过限制则保存 */
					$table_df = $this->get_table_df($table, true);
					if (strlen($this->dump_sql) + strlen($table_df) > $this->max_size - 32)
					{
						if ($this->sql_num == 0)
						{
							/* 第一条记录，强制写入 */
							$this->dump_sql .= $table_df;
							$this->sql_num +=2;
							$tables[$table] = 0;
						}
						/* 已经达到上限 */
	
						break;
					}
					else
					{
						$this->dump_sql .= $table_df;
						$this->sql_num +=2;
						$pos = 0;
					}
				}
	
				/* 尽可能多获取数据表数据 */
				$post_pos = $this->get_table_data($table, $pos);
	
				if ($post_pos == -1)
				{
					/* 该表已经完成，清除该表 */
					unset($tables[$table]);
				}
				else
				{
					/* 该表未完成。说明将要到达上限,记录备份数据位置 */
					$tables[$table] = $post_pos;
					break;
				}
			}
	
			$this->dump_sql .= '-- END ecshop v2.x SQL Dump Program ';
			$this->put_tables_list($path, $tables);
	
			return $tables;
		}
	
		 /**
		 *  获取指定表的数据定义
		 *
		 * @access  public
		 * @param   string      $table      表名
		 * @param   int         $pos        备份开始位置
		 *
		 * @return  int         $post_pos   记录位置
		 */
		function get_table_data($table, $pos)
		{
			$post_pos = $pos;
	
			/* 获取数据表记录总数 */
			$total = $this->db->findvar("SELECT COUNT(*) FROM $table");
	
			if ($total == 0 || $pos >= $total)
			{
				/* 无须处理 */
				return -1;
			}
	
			/* 确定循环次数 */
			$cycle_time = ceil(($total-$pos) / $this->offset); //每次取offset条数。需要取的次数
	
			/* 循环查数据表 */
			for($i = 0; $i<$cycle_time; $i++)
			{
				/* 获取数据库数据 */
				$data = $this->db->find("SELECT * FROM $table LIMIT " . ($this->offset * $i + $pos) . ', ' . $this->offset);
				$data_count = count($data);
	
				$fields = array_keys($data[0]);
				$start_sql = "INSERT INTO `$table` ( `" . implode("`, `", $fields) . "` ) VALUES ";
	
				/* 循环将数据写入 */
				for($j=0; $j< $data_count; $j++)
				{
					$record = array_map("dump_escape_string", $data[$j]);   //过滤非法字符
					$record = array_map("dump_null_string", $record);     //处理null值

					/* 检查是否能写入，能则写入 */
					if ($this->is_short)
					{
						if ($post_pos == $total-1)
						{
							$tmp_dump_sql = " ( '" . implode("', '" , $record) . "' );\r\n";
						}
						else
						{
							if ($j == $data_count - 1)
							{
								$tmp_dump_sql = " ( '" . implode("', '" , $record) . "' );\r\n";
							}
							else
							{
								$tmp_dump_sql = " ( '" . implode("', '" , $record) . "' ),\r\n";
							}
						}
	
						if ($post_pos == $pos)
						{
							/* 第一次插入数据 */
							$tmp_dump_sql = $start_sql . "\r\n" . $tmp_dump_sql;
						}
						else
						{
							if ($j == 0)
							{
								$tmp_dump_sql = $start_sql . "\r\n" . $tmp_dump_sql;
							}
						}
					}
					else
					{
						$tmp_dump_sql = $start_sql . " ('" . implode("', '" , $record) . "');\r\n";
					}

					$tmp_str_pos = strpos($tmp_dump_sql, 'NULL');         //把记录中null值的引号去掉
					$tmp_dump_sql = empty($tmp_str_pos) ? $tmp_dump_sql : substr($tmp_dump_sql, 0, $tmp_str_pos - 1) . 'NULL' . substr($tmp_dump_sql, $tmp_str_pos + 5);
	
					if (strlen($this->dump_sql) + strlen($tmp_dump_sql) > $this->max_size - 32)
					{
						if ($this->sql_num == 0)
						{
							$this->dump_sql .= $tmp_dump_sql; //当是第一条记录时强制写入
							$this->sql_num++;
							$post_pos++;
							if ($post_pos == $total)
							{
								/* 所有数据已经写完 */
								return -1;
							}
						}
	
						return $post_pos;
					}
					else
					{
						$this->dump_sql .= $tmp_dump_sql;
						$this->sql_num++; //记录sql条数
						$post_pos++;
					}
				}
			}

			/* 所有数据已经写完 */
			return -1;
		}
		
		   /**
		 *  生成备份文件头部
		 *
		 * @access  public
		 * @param   int     文件卷数
		 *
		 * @return  string  $str    备份文件头部
		 */
		function make_head($vol)
		{
			/* 系统信息 */
			$sys_info['php_ver']    = PHP_VERSION;
			$sys_info['mysql_ver']  = $this->db->version();
			$sys_info['date']       = date('Y-m-d H:i:s');
	
			$head = "-- ecshop v2.x SQL Dump Program\r\n".
					 "-- \r\n".
					 "-- MYSQL SERVER VERSION : ".$sys_info['mysql_ver']."\r\n".
					 "-- PHP VERSION : ".$sys_info['php_ver']."\r\n".
					 "-- BACKDB DATE : ".$sys_info['date']."\r\n".
					 "-- Vol : " . $vol . "\r\n";
	
			return $head;
		}
		
		 /**
		 *  获取指定表的定义
		 *
		 * @access  public
		 * @param   string      $table      数据表名
		 * @param   boolen      $add_drop   是否加入drop table
		 *
		 * @return  string      $sql
		 */
		function get_table_df($table, $add_drop = false)
		{
			if ($add_drop)
			{
				$table_df = "DROP TABLE IF EXISTS `$table`;\r\n";
			}
			else
			{
				$table_df = '';
			}
	
			$tmp_arr = $this->db->findrow("SHOW CREATE TABLE `$table`");
			$tmp_sql = $tmp_arr['Create Table'];
			$tmp_sql = substr($tmp_sql, 0, strrpos($tmp_sql, ")") + 1); //去除行尾定义。

			if ($this->db->version() >= '4.1')
			{
				$table_df .= $tmp_sql . " ENGINE=MyISAM DEFAULT CHARSET=" . str_replace('-', '', 'utf-8') . ";\r\n";
			}
			else
			{
				$table_df .= $tmp_sql . " TYPE=MyISAM;\r\n";
			}
	
			return $table_df;
		}
	
		 /**
		 *  返回错误信息
		 *
		 * @access  public
		 * @param
		 *
		 * @return void
		 */
		function errorMsg()
		{
			return $this->error_msg;
		}

}
?>