<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuthTablesMod extends Migration
{
    public function up()
    {
        $this->db->query("DROP INDEX email ON users")->getResult();
        $this->db->query("DROP INDEX username ON users")->getResult();
        $this->db->query("ALTER TABLE users ADD CONSTRAINT users_email_unique UNIQUE (email, deleted_at)")->getResult();
        $this->db->query("ALTER TABLE users ADD CONSTRAINT users_username_unique UNIQUE (username, deleted_at)")->getResult();
    }
    
    public function down()
    {
        
    }
}
