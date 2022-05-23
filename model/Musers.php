<?php

    class Musers
    {
        private $content;
        private $dbcon;


    //Вызов
        function execute()
        {
            $this->content = "Список пользователей";
            $this->dbconnect();

            if(isset($_GET["adduser"])){
                $this->adduser();
            }
            else if(isset($_GET["edit"])){
                $this->edituser();
            } 
            else {
                $this->showlist();
            }

            return $this->content;
            
        }

        //Подключения к бд
        function dbconnect(){
            include("dbcon.php");
            $dsn = $type.":host=".$host.";dbname=".$base;
            $opt = array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            );
            $this->dbcon = new PDO($dsn, $user, $pasw, $opt);
        }

        //Форма
        function forma($data){
            $frm = new Tform;
            $frm->addparams("method=\"post\"");
            $frm->addparams("class=\"\"");
            $frm->addtextfield("first_name", $data["first_name"], "Введите имя пользователя", "Имя пользователя", 1);
            $frm->addtextfield("last_name", $data["last_name"], "Введите фамилию пользователя", "Фамилия пользователя", 1);
            $frm->addtextfield("email",$data["email"], "Введите email пользователя", "Email пользователя", 1);
            $frm->addtextfield("company_name",$data["company_name"], "Введите компанию пользователя", "Компания пользователя", 0);
            $frm->addtextfield("position",$data["position"], "Введите должность пользователя", "Должность пользователя", 0);
            $frm->addtextfield("phone1",$data["phone1"], "Введите первый телефон пользователя", "Первый телефон пользователя", 0);
            $frm->addtextfield("phone2",$data["phone2"], "Введите второй телефон пользователя", "Второй телефон пользователя", 0);
            $frm->addtextfield("phone3",$data["phone3"], "Введите третий телефон пользователя", "Третий телефон пользователя", 0);
            $frm->addsubmitfield("saveitem", "Сохранить");
            $this-> content.= 
            "<div class = \"container\">". 
            "<div class = \"row\">".
            $frm->out().
            "</div>". 
            "</div>";
        }

        //Редактирование пользователя
        function edituser(){

            $itemid = $_GET["edit"];
            $userobj = $this->dbcon->query('SELECT * FROM users where id = '.$itemid. '');
            $phonelist = $this->dbcon->query('SELECT * FROM phone where user_id = '.$itemid.'');
            $phone = $phonelist->fetchAll();

            //Чтение данных из БД

            while ($user = $userobj->fetch()){
                $data = [];
                $phone_con = [];
                $data["first_name"] = $user["first_name"];
                $data["last_name"] = $user["last_name"];
                $data["email"] = $user["email"];
                $data["company_name"] = $user["company_name"];
                $data["position"] = $user["position"];
                foreach ($phone as $key => $phone_item){
                    if($phone_item["number"] == 1){
                        $data["phone1"] = $phone_item["phone"];
                        $phone_con["id1"] = $phone_item["id"];
                        $phone_con["phone1"] = $data["phone1"];
                    } 
                    if($phone_item["number"] == 2){
                        $data["phone2"] = $phone_item["phone"];
                        $phone_con["id2"] = $phone_item["id"];
                        $phone_con["phone2"] =  $data["phone2"];
                    }
                    if($phone_item["number"] == 3){
                        $data["phone3"] = $phone_item["phone"];
                        $phone_con["id3"] = $phone_item["id"];
                        $phone_con["phone3"] = $data["phone3"];
                    }
                    
                }
            }
           
            $this->content="<h3>Редактировать</h3>";
            $this->forma($data);

            //Сохранение данных
            if(isset($_POST["saveitem"])){
                $data = [];
                $data["first_name"] = $_POST["first_name"];
                $data["last_name"] = $_POST["last_name"];
                $data["email"] = $_POST["email"];
                $data["company_name"] = $_POST["company_name"];
                $data["position"] = $_POST["position"];
                $data["phone1"] = $_POST["phone1"];
                $data["phone2"] = $_POST["phone2"];
                $data["phone3"] = $_POST["phone3"];
                $conf = [
                    'first_name' => $data["first_name"],
                    'last_name' => $data["last_name"],
                    'email' => $data["email"],
                    'company_name' => $data["company_name"],
                    'position' => $data["position"],
                ];

                $sql =  'UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, company_name = :company_name, position = :position WHERE id = '.$itemid.'';
                $stmt= $this->dbcon->prepare($sql);
                $stmt->execute($conf);

                if($data["phone1"] && $phone_con["phone1"] && $data["phone1"] != $phone_con["phone1"]){
                    $sql = "UPDATE phone SET phone = ".$data["phone1"]." WHERE id =".$phone_con["id1"]."";
                    $stmt = $this->dbcon->exec($sql);
                } else if (!$phone_con["phone1"] && $data["phone1"]){
                    $sql =  'INSERT INTO phone (user_id, phone, number) VALUES ('.$itemid.','.$data["phone1"].', 1)';
                    $stmt = $this->dbcon->exec($sql);
                }

                if($data["phone2"] && $phone_con["phone2"]&& $data["phone2"] != $phone_con["phone2"]){
                    $sql = "UPDATE phone SET phone = ".$data["phone2"]." WHERE id =".$phone_con["id2"]."";
                    $stmt = $this->dbcon->exec($sql);
                } else if(!$phone_con["phone2"] && $data["phone2"]){
                    $sql =  'INSERT INTO phone (user_id, phone,number) VALUES ('.$itemid.','.$data["phone2"].', 2)';
                    $stmt = $this->dbcon->exec($sql);
                }

                if($data["phone3"] && $phone_con["phone3"]&& $data["phone3"] != $phone_con["phone3"]){
                    $sql = "UPDATE phone SET phone = ".$data["phone3"]." WHERE id =".$phone_con["id3"]."";
                    $stmt = $this->dbcon->exec($sql);
                } else if(!$phone_con["phone3"] && $data["phone3"]){
                    $sql =  'INSERT INTO phone (user_id, phone, number) VALUES ('.$itemid.','.$data["phone3"].', 3)';
                    $stmt = $this->dbcon->exec($sql);
                }
                
                header("Location: /");
            }   
        }

        //Новый пользователь
        function adduser(){
            if(isset($_POST["saveitem"])){
            $data = [];
            $data["first_name"] = $_POST["first_name"];
            $data["last_name"] = $_POST["last_name"];
            $data["email"] = $_POST["email"];
            $data["company_name"] = $_POST["company_name"];
            $data["position"] = $_POST["position"];
            $data["phone1"] = $_POST["phone1"];
            $data["phone2"] = $_POST["phone2"];
            $data["phone3"] = $_POST["phone3"];
            $conf = [
                'first_name' => $data["first_name"],
                'last_name' => $data["last_name"],
                'email' => $data["email"],
                'company_name' => $data["company_name"],
                'position' => $data["position"],
            ];

            $sql =  'INSERT INTO users (first_name, last_name, email, company_name, position) VALUES 
            (:first_name,
            :last_name,
            :email,
            :company_name,
            :position)';

            $stmt= $this->dbcon->prepare($sql);
            $stmt->execute($conf);

            $userlist = $this->dbcon->query('SELECT id FROM users where del = 0 ORDER BY ID DESC ');
            $user_last = $user = $userlist->fetch();

            if($data["phone1"]){
                $sql =  'INSERT INTO phone (user_id, phone, number) VALUES ('.$user_last["id"].','.$data["phone1"].', 1)';
                $stmt = $this->dbcon->exec($sql);
            }
            if($data["phone2"]){
                $sql =  'INSERT INTO phone (user_id, phone, number) VALUES ('.$user_last["id"].','.$data["phone2"].', 2)';
                $stmt = $this->dbcon->exec($sql);
            }
            if($data["phone3"]){
                $sql =  'INSERT INTO phone (user_id, phone, number) VALUES ('.$user_last["id"].','.$data["phone3"].', 3)';
                $stmt = $this->dbcon->exec($sql);
            }
            header("Location: /");
        }   
        
        $this->content="<h3>Создание пользователя</h3>";
        //Создание формы
        $this->forma($data);
    }
    //Вывода данных с бд
    function showlist(){

        if (isset($_GET['page'])){
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        $limit = 10;
        $number = ($page * $limit) - $limit;
        $userall = $this->dbcon->query('SELECT * FROM users where del = 0 ');
        $user_all = $userall->fetchAll();
        
        $user_count = count($user_all);
        
        $str_pag = ceil($user_count/$limit);
        $query = $this->dbcon->query('SELECT * FROM users WHERE del = 0 ORDER BY id  LIMIT '.$number.', '.$limit.' ');
        
        $phonelist = $this->dbcon->query('SELECT * FROM phone');
        $phone = $phonelist->fetchAll();
        $btn="<a href=\"?adduser\" class=\"btn btn-sm btn-primary\" title=\"Добавить пользователя\">+</a>";
        $this->content="<h3>Список пользователей $btn</h3>";
        if(isset($_GET["del"])){
            $itemid = $_GET["del"];
            $query = "UPDATE users SET del = 1 WHERE id = ".$itemid."";
            $stmt = $this->dbcon->exec($query);
            header("Location: /");
        }


        //Создание таблицы и ее заполнение
        $tbl = new Ttable;
        $tbl->addparams("class=\"table table-striped table-sm\"");
        
        $tbl->startrow();
        $tbl->addcell("id");
        $tbl->addcell("Имя");
        $tbl->addcell("Фамилия");
        $tbl->addcell("Email");
        $tbl->addcell("Компания");
        $tbl->addcell("Должность");
        $tbl->addcell("Первый телефон");
        $tbl->addcell("Второй телефон");
        $tbl->addcell("Третий телефон");
        $tbl->finishrow();
        
        while ($user = $query->fetch()){
            $tbl->startrow();
            $id = $user['id'];
            $tbl->addcell($user['id']);
            $tbl->addcell($user['first_name']);
            $tbl->addcell($user['last_name']);
            $tbl->addcell($user['email']);
            if($user['company_name']){
                $tbl->addcell($user['company_name']);
            } else{
                $tbl->addcell("Пусто");
            }
            if($user['position']){
                $tbl->addcell($user['position']);
            } else {
                $tbl->addcell("Пусто");
            }
            $index = 0;
            foreach ($phone as $key => $phone_item){
                if($id == $phone_item['user_id'] && $phone_item['number'] == 1){
                    $tbl->addcell($phone_item['phone']);
                    $index++;
                } 
            }

            if($index == 1) {
                $index = 0;
            } else {
                $tbl->addcell("Пусто");
            }

            foreach ($phone as $key => $phone_item){
                if($id == $phone_item['user_id'] && $phone_item['number'] == 2){
                    $tbl->addcell($phone_item['phone']);
                    $index++;
                }
            }

            if($index == 1) {
                $index = 0;
            } else {
                $tbl->addcell("Пусто");
            }

            foreach ($phone as $key => $phone_item){
                if($id == $phone_item['user_id']  && $phone_item['number'] == 3){
                    $tbl->addcell($phone_item['phone']);
                    $index++;
                }
            }

            if($index == 1) {
                $index = 0;
            } else {
                $tbl->addcell("Пусто");
            }

            $tbl->addcell("<a href = \?edit=".$user["id"].">Редактировать</a>");
            $tbl->addcell("<a href = \?del=".$user["id"].">Удалить</a>");
            $tbl->finishrow();
        }

        //Вывод таблицы + pagination
        $this->content.=$tbl->out();
        $up = $page+1;
        $down = $page-1;
        $this->content.= 
        "<nav aria-label='Page navigation example'>
        <ul class='pagination'>";

        if($page!=1){
            $this->content.= "
            <li class='page-item'><a class='page-link' href='/?page=".$down."'>Назад</a></li>";
        }else {
            $this->content.= "
            <li class='page-item'><a class='page-link' href='/?page=".$page."'>Назад</a></li>";
        }
        
        for ($i = 1; $i <=$str_pag; $i++){
            $this-> content.= "<li class='page-link'><a href=/?page=".$i.">".$i."</a> </li>";
        }	

        if($str_pag != $page){
            $this->content.= "
            <li class='page-item'><a class='page-link' href='/?page=".$up."'>Вперед</a></li>";
        }else if($page>=1){
            $this->content.= "
            <li class='page-item'><a class='page-link' href='/?page=".$page."'>Вперед</a></li>";
        }
        $this->content.=
        "
        </ul>
        </nav>";
        
        //Страница ошибки
        if($_GET["page"]>$str_pag){
            header("Location: /template/404.html");
        }

    }
}