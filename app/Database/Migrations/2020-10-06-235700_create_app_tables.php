<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Description of CreateAppTables
 *
 * @author rajnish
 */
class CreateAppTables extends Migration
{
    public function up()
    {
        // Reject if not mysql
        if ($this->db->DBDriver != 'MySQLi')
        {
            echo 'This website is intented to work only with MySQL databases!';
            return;
        }
        
        // Creating table books
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'img'           => ['type' => 'TEXT', 'null' => true],
            'author'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'genre'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'category'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'edition'       => ['type' => 'INT', 'constraint' => 4, 'default' => 1],
            'isbn'          => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true],
            'publ'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'desc'          => ['type' => 'TEXT', 'null' => true],
            'price'         => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0.0],
            'charge'        => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0.0],
            'date'          => ['type' => 'DATE', 'null' => true],
            'amt'           => ['type' => 'INT', 'constraint' => 4, 'unsigned' => true],
            'sec'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'shelf'         => ['type' => 'INT', 'constraint' => 2],
            'row'           => ['type' => 'INT', 'constraint' => 2],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true],
            'deleted_at'    => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("UNIQUE books_id_unique (id, deleted_at)");
        $this->forge->addKey('author');
        $this->forge->addKey('genre');
        $this->forge->addKey('category');
        $this->forge->addKey('isbn');
        $this->forge->addKey('publ');
        $this->forge->createTable('books', true);
        
        // Creating table members
        $this->forge->addField([
            'id'            => ['type' => 'VARCHAR', 'constraint' => 100],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'phone'         => ['type' => 'VARCHAR', 'constraint' => 20],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'address'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'city'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'state'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'country'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'pin'           => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'prof'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'desg'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'corp'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true],
            'deleted_at'    => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("UNIQUE members_id_unique (id, deleted_at)");
        $this->forge->createTable('members', true);
        
        // Creating table visitors_record
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'mem_id'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'phone'         => ['type' => 'VARCHAR', 'constraint' => 20],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'address'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'city'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'state'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'country'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'pin'           => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'prof'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'desg'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'corp'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'time_in'       => ['type' => 'datetime'],
            'time_out'      => ['type' => 'datetime', 'null' => true],
            'charge'        => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0.0],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('mem_id', 'members', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('visitors_record', true);
        
        // Creating table mem_record
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'mem_id'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'date'          => ['type' => 'DATE'],
            'valid_until'   => ['type' => 'DATE'],
            'charge'        => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0.0],
            'paid'          => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0.0],
            'remain'        => ['type' => 'DECIMAL(5,2) AS (`charge`-`paid`) VIRTUAL', 'null' => true],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('mem_id', 'members', 'id', 'CASCADE', false);
        $this->forge->createTable('mem_record', true);
        
        // Creating table issue_record
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'renew_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'mem_id'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'book_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'fine_rate'     => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0.0],
            'date'          => ['type' => 'DATE'],
            'eret_date'     => ['type' => 'DATE'],
            'aret_date'     => ['type' => 'DATE'],
            'addfine'       => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0.0],
            'fine'          => ['type' => 'DECIMAL(5,2) AS (DATEDIFF(`aret_date`,`eret_date`)*`fine_rate`+`addfine`) VIRTUAL', 'null' => true],
            'paid'          => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0.0],
            'remain'        => ['type' => 'DECIMAL(5,2) AS (`fine`-`paid`) VIRTUAL', 'null' => true],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('mem_id', 'members', 'id', 'CASCADE', false);
        $this->forge->addForeignKey('book_id', 'books', 'id', 'CASCADE', false);
        $this->forge->createTable('issue_record', true);
        
        // Creating table app_conf
        $this->forge->addField([
            'late_fine'     => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0.0]
        ]);
        $this->forge->createTable('app_conf', true);
    }
    
    public function down()
    {
        // Reject if not mysql
        if ($this->db->DBDriver != 'MySQLi')
        {
            echo 'This website is intented to work only with MySQL databases!';
            return;
        }
        
        // Remove foreign keys
        $this->forge->dropForeignKey('visitors_record', 'visitors_record_mem_id_foreign');
        $this->forge->dropForeignKey('mem_record', 'mem_record_mem_id_foreign');
        $this->forge->dropForeignKey('issue_record', 'issue_record_mem_id_foreign');
        $this->forge->dropForeignKey('issue_record', 'issue_record_book_id_foreign');
        
        // Removing tables
        $this->forge->dropTable('books', true);
        $this->forge->dropTable('members', true);
        $this->forge->dropTable('visitors_record', true);
        $this->forge->dropTable('mem_record', true);
        $this->forge->dropTable('issue_record', true);
        $this->forge->dropTable('app_conf', true);
    }
}
