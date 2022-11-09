<?php

namespace Mbere250\IDify;
use Illuminate\Support\Facades\DB;
use Exception;

class IDify
{

    public static $length = 4;
    public static $table;
    public static $model;
    public static $column;
    public static $prefix;
    public static $separator = '-';
    public static $generated_ID;

    protected static $onlyInstance;

    // protected function __construct () { }

    protected static function getself()
    {
        if (static::$onlyInstance === null) 
        {
            static::$onlyInstance = new IDify;
        }

        return static::$onlyInstance;
    }

    /**
     * @param string $name
     * @return static::getself()
     */
    public static function table($name) 
    {
        static::$table = $name;
        return static::getself();
    }
     /**
     * @param string $name
     * @return static::getself()
     */
    public static function model($name) 
    {
        static::$model = $name;
        return static::getself();
    }
     /**
     * @param string $value
     * @return static::getself()
     */
    public static function column($value) 
    {
        static::$column = $value;
        return static::getself();
    }
     /**
     * @param string $value
     * @return static::getself()
     */
    public static function prefix($value) 
    {
        static::$prefix = $value;
        return static::getself();
    }
     /**
     * @param string $value
     * @return static::getself()
     */
    public static function separator($value = '-') 
    {
        static::$separator = $value;
        return static::getself();
    }
     /**
     * @param string $value
     * @return static::getself()
     */
    public static function length($value = 4) 
    {
        static::$length = $value;
        return static::getself();
    }
   
    public static function generate()
    {
        $_column = self::$column;
        $_table_model = null;

        if( !self::$prefix ){
            throw new Exception(' "prefix()" on chain is required');
        }

        if( !self::$model && !self::$table){
            throw new Exception(' "table()" or "model()" on chain is required');
        }
        if( self::$model && self::$table ){
            throw new Exception('Only on function allowed. Choose "table()" or "model()"');
        }

        if( self::$model ){
            $_table_model = self::$model;
        }

        if( self::$table ){
            $_table_model = DB::table(self::$table);
        }

        $connection = config('database.default');
        $database = DB::connection($connection)->getDatabaseName();
     
        $isTableEmpty = self::$model ? $_table_model::all() : $_table_model->get();
        if($isTableEmpty->isEmpty()){
            self::$model ? $_table_model::truncate() : $_table_model->truncate(); //Reset Table Auto increment to 1//
            $set_length = self::$length - 1;
            $last_number = 1;
            $zeros = "";
              for($i=0;$i<$set_length;$i++){
                $zeros.="0";
            }     
            static::$generated_ID = self::$prefix.self::$separator.$zeros.$last_number;
        }else{

            $full_prefix = self::$prefix.self::$separator;
            $term = "%$full_prefix%";
            
            $query = $_table_model->where(function($q) use ($term, $_column){
                $q->where($_column,'like', $term);
            })->get();

     


            if( $query->count() == 0 ){

                $set_length = self::$length - 1;
                $last_number = 1;
                $zeros = "";
                  for($i=0;$i<$set_length;$i++){
                    $zeros.="0";
                }     
                static::$generated_ID = self::$prefix.self::$separator.$zeros.$last_number;

            }else{
                
                $data = $_table_model->where(function($query) use ($term, $_column){
                    $query->where($_column,'like', $term);
                })->orderBy('id','desc')->first();

                if( substr($data->$_column, 0, strlen(self::$prefix.self::$separator)) === self::$prefix.self::$separator ){

                    $code = substr($data->$_column, strlen(self::$prefix)+1);
                    $actial_last_number = ($code/1)*1;
                    $increment_last_number = ((int)$actial_last_number)+1;
                    $last_number_length = strlen($increment_last_number);
                    $og_length = self::$length - $last_number_length;
                    $last_number = $increment_last_number;

                    $zeros = "";
                    for($i=0;$i<$og_length;$i++){
                        $zeros.="0";
                    }

                    static::$generated_ID = self::$prefix.self::$separator.$zeros.$last_number;

                }else{

                    $set_length = self::$length - 1;
                    $last_number = 1;
                    $zeros = "";
                      for($i=0;$i<$set_length;$i++){
                        $zeros.="0";
                    }     

                    static::$generated_ID = self::$prefix.self::$separator.$zeros.$last_number;
                }
            
            }
        }
       
       return static::$generated_ID;
        
    }


}