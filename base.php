<?php

session_start();
date_default_timezone_set('Asia/Taipei');

class DB{
    protected $table;
    protected $dsn='mysql:host=localhost;charset=utf8;dbname=db19';
    protected $pdo;

    function __construct($table)
    {
        $this->table=$table;
        $this->pdo=new PDO($this->dsn,'root','');
    }

    function all(...$arg){
        $sql="select * from $this->table ";
        if(isset($arg[0])){
            if(is_array($arg[0])){
                foreach($arg[0] as $key => $val){
                    $tmp[]="`$key`='$val'";
                }

                $sql .= " where " . join(" && ",$tmp);
            }else{
                $sql .= $arg[0];
            }
        }

        if(isset($arg[1])){
            $sql .= $arg[1];
        }

        echo $sql;
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    function find($arg){
        $sql="select * from $this->table where";

        if(is_array($arg)){
            foreach($arg as $key => $val){
                $tmp[]="`$key`='$val'";
            }
            $sql .= join(" && ",$tmp);
        }else{
            $sql .= "`id`='$arg'";
        }
        echo $sql;
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    function save($array){
        if(isset($array['id'])){
            foreach($array as $key => $val){
                $tmp[]="`$key`='$val'";
            }

            $sql="update $this->table set  ".join(',',$tmp)."  where `id`='{$array['id']}'";
        }else{
            $sql="insert into $this->table (`".join("`,`",array_keys($array))."`)
                                        values('".join("','",$array)."')";
        }

        return $this->pdo->exec($sql);
    }
    function del($arg){
        $sql="delete from $this->table where";
            if(is_array($arg)){
                foreach($arg as $key => $val){
                    $tmp[]="`$key`='$val'";
                }
                $sql .= join(" && ",$tmp);
            }else{
                $sql .= " `id`='$arg'";
            }

            return $this->pdo->exec($sql);
    }
    function math($math,$col,...$arg){
        $sql="select $math($col) from $this->table ";
            if(isset($arg[0])){
                if(is_array($arg[0])){
                    foreach($arg[0] as $key => $val){
                        $tmp[]="`$key`='$val'";
                    }
                    $sql .= " where " . join(" && ",$tmp);
                }else{
                    $sql .= $arg[0];
                }
            }
            if(isset($arg[1])){
                $sql .= $arg[1];
            }

            return $this->pdo->query($sql)->fetchColumn();
    }
    function q($sql){
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
    function dd($array){
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
    function to($url){
        header('location:'.$url);
    }



$Total=new DB('total');



?>