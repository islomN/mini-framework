<?php
namespace app\core\model;

use app\core\base\Model;
use app\core\db\Db;
use app\core\traits\Magic;
use app\core\traits\Singleton;

class DbModel extends Model {

    use Magic;
    use Singleton;

    const SORT_DESC = "desc";
    const SORT_ASC = "asc";

    protected $query;
    protected $where;
    protected $orderBy;
    protected $limit;
    protected $offset;

    protected $whereCount = 0;

    protected $args = [];

    protected static $defaultTable;
    protected static $db = null;

    public $typeQuery;

    public static function create($data){
        $self = static::Instance();
        $self->emptyItems();
        $self->args = [];
        $self->typeQuery = 1;
        $self->query = "INSERT INTO ".static::$defaultTable.$self->forSetQuery($data);

        return $self;
    }

    public static function update($data){

        $self = static::Instance();
        $self->emptyItems();
        $self->args = [];
        $self->typeQuery = 0;
        $self->query = "update  ".static::$defaultTable .$self->forSetQuery($data);
        return $self;
    }

    public static function  delete(){
        $self = static::Instance();
        $self->emptyItems();
        $self->args = [];
        $self->typeQuery = 1;
        $self->query = "delete from  ".static::$defaultTable ;
        return $self;
    }

    public static  function select($column = "*"){
        $self = static::Instance();
        $self->emptyItems();
        $self->query = "select ".$column." FROM ". static::$defaultTable;
        return $self;
    }

    public function one(){
        $this->queryJoin();

        return static::getDB()->getOneQuery($this->query, $this->args);
    }

    public function all(){
        $this->queryJoin();

        return static::getDB()->getQuery($this->query, $this->args);
    }

    public function exec(){
        $this->queryJoin();
        return static::getDB()->setQuery($this->query, $this->args, $this->typeQuery);
    }

    public function where($condition, $del = "and", $addWhereDel = "and"){
        $this->whereCount++;
        $genArgs = static::generateArgs($condition, $this->whereCount);

        $this->args = array_merge($this->args, $genArgs['args']);

        $this->where .= ($this->where ? " ".$addWhereDel." " : null)
                        . "( ". implode(" ".$del. " ", $genArgs['query']) . " )";

        return $this;
    }

    public function andWhere($condition, $del){
        $this->where($condition, $del, "and");
    }

    public function orWhere($condition, $del){
        $this->where($condition, $del, "or");
    }

    public function getQuery(){
        $this->queryJoin();
        return $this->query;
    }


    public function orderBy(array $args){
        $items = [];

        foreach($args as  $key => $arg){
            $items[] = $key ." ". $arg;
        }
        $this->orderBy = implode(", ", $items);
        return $this;
    }

    public function limit($offset = 0, $limit = 5){
        $limit = (int)$limit;
        $offset = (int)$offset;
        $this->limit = (int)$limit . ($offset > 0 ? ", ".$offset : null);
        return $this;
    }


    protected function queryJoin(){
        if($this->whereCount){
            $this->query .= " WHERE ".$this->where;
        }

        if($this->orderBy){
            $this->query .= " ORDER BY ".$this->orderBy;
        }

        if($this->limit){
            $this->query .= " limit ".$this->limit;
        }
    }

    protected function generateArgs($args, $prefix = ""){
        $genArgs = [];
        $queryArgs = [];
        $i=0;

        foreach($args as $key => $value){

            if(is_array($value)){

                if(count($value) != 3)
                    continue;
                $injKey = ":{$value[0]}"."_$i"."_".$prefix;
                $genArgs[$injKey] = $value[2];
                $queryArgs[$key] = $value[0] . " " .$value[1] . " " .$injKey;
                $i++;
            }else{
                $injKey = ":$key"."_$i"."_".$prefix;
                $genArgs[$injKey] = $value;
                $queryArgs[$key] = $key ."=".$injKey;
                $i++;
            }
        }

        return ["args" => $genArgs, "query" => $queryArgs];
    }

    protected function forSetQuery($data){
        $genArgs = static::generateArgs($data);

        $this->args = $genArgs['args'];

        return " set " .implode(", ", $genArgs['query']);
    }

    protected static function getDB(){

        if(static::$db == null){
            static::$db = new Db();
        }


        return static::$db;
    }

    protected function emptyItems(){
        $this->where = $this->query = $this->limit
                    = $this->orderBy = $this->offset
                    = $this->whereCount = null;
        $this->args = [];
    }
}