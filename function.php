<?php
    Class crudApp{
        private $conn;

        public function __construct()
        {
            #database host, database user, database pass, database name
            $dbhost = 'localhost';
            $dbuser = 'root';
            $dbpass = 'mysql';
            $dbname = 'crudapp';

            $this->conn= mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
            
            if(!$this->conn){
                die("Database Connection Error!!");
            }
        }


        public function add_data($data){
            $std_name = $data['std_name'];
            $std_roll = $data['std_roll'];
            $std_img = $_FILES['std_img']['name'];
            $tmp_name = $_FILES['std_img']['tmp_name'];
            
            $query = "INSERT INTO students(std_name,std_roll,std_img) VALUE('$std_name',$std_roll,'$std_img')";
            
            
            if(mysqli_query($this->conn, $query)){
                move_uploaded_file($tmp_name, 'upload/'.$std_img);
                return "Information Added Successfully";
            }
        }
        public function display_data(){
            $query = "SELECT * FROM students";
            if(mysqli_query($this->conn, $query)){
            $display = mysqli_query($this->conn, $query);
            return $display;
            }
        }
        public function display_data_by_id($id){
            $query = "SELECT * FROM students WHERE id=$id";
            if(mysqli_query($this->conn, $query)){
            $display = mysqli_query($this->conn, $query);
            $display_data = mysqli_fetch_assoc($display);
            return $display_data;
            }
        }
        public function update_data($data){
           $std_name = $data['u_std_name'];
           $std_roll = $data['u_std_roll'];
           $std_id   = $data['std_id'];
           $std_img  = $_FILES['u_std_img']['name'];
           $tmp_name = $_FILES['u_std_img']['tmp_name'];

           $query = "UPDATE students SET std_name='$std_name', std_roll=$std_roll, std_img='$std_img' WHERE id=$std_id";

           if(mysqli_query($this->conn, $query)){
               move_uploaded_file($tmp_name, 'upload/'.$std_img);
               return "Information updated sucessfully";
           }

        }

        
        public function delete_data($id){
            $catch_img = "SELECT * FROM students WHERE id=$id";
            $delete_std_info = mysqli_query($this->conn, $catch_img);
            $info_del = mysqli_fetch_assoc($delete_std_info);
            $deleted_img = $info_del['std_img'];
            $query = "DELETE FROM students WHERE id=$id ";
            if(mysqli_query($this->conn, $query)){
                unlink('upload/'.$deleted_img);
                return "Data deleted sucessfully";
            }
        }
    }



?>