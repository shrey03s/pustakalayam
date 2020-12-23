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
        
        // Creating function JSON_ARRSUM() which finds the sum of the values in float json arrays
        $this->db->simpleQuery(""
                . "CREATE FUNCTION JSON_ARRSUM ( jarr JSON ) RETURNS FLOAT DETERMINISTIC\n"
                . "BEGIN\n"
                . "    DECLARE i INT UNSIGNED DEFAULT 0;\n"
                . "    DECLARE l INT UNSIGNED DEFAULT JSON_LENGTH(jarr);\n"
                . "    DECLARE s FLOAT DEFAULT 0.0;\n"
                . "    IF NOT JSON_VALID(jarr) THEN"
                . "        RETURN 0.0;\n"
                . "    END IF;\n"
                . "    WHILE i < l DO\n"
                . "        SET s := s + CAST(JSON_EXTRACT(jarr, CONCAT('$[',i,']')) AS FLOAT);\n"
                . "        SET i := i + 1;\n"
                . "    END WHILE;\n"
                . "    RETURN s;\n"
                . "END;");
        
        // Creating table vehicles
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'vin'       => ['type' => 'VARCHAR', 'constraint' => 30],
            'type'      => ['type' => 'VARCHAR', 'constraint' => 30],
            'date'      => ['type' => 'DATE', 'null' => true],
            'created_at'=> ['type' => 'datetime', 'null' => true],
            'updated_at'=> ['type' => 'datetime', 'null' => true],
            'deleted_at'=> ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("UNIQUE vehicles_vin_unique (vin, deleted_at)");
        $this->forge->addKey('type');
        $this->forge->createTable('vehicles', true);
        
        // Creating table depot
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'incharge'  => ['type' => 'VARCHAR', 'constraint' => 100],
            'phone'     => ['type' => 'VARCHAR', 'constraint' => 20,  'null' => true],
            'email'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'address'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'city'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'state'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'country'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'area_pin'  => ['type' => 'VARCHAR', 'constraint' => 10,  'null' => true],
            'rawamt'    => ['type' => 'DECIMAL', 'constraint' => '8,4', 'default' => 0.0],
            'cookamt'   => ['type' => 'DECIMAL', 'constraint' => '8,4', 'default' => 0.0],
            'created_at'=> ['type' => 'datetime', 'null' => true],
            'updated_at'=> ['type' => 'datetime', 'null' => true],
            'deleted_at'=> ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("UNIQUE depot_name_unique (name, deleted_at)");
        $this->forge->addKey('incharge');
        $this->forge->createTable('depot', true);
        
        // Creating table mine
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'address'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'city'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'state'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'country'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'area_pin'  => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'created_at'=> ['type' => 'datetime', 'null' => true],
            'updated_at'=> ['type' => 'datetime', 'null' => true],
            'deleted_at'=> ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("UNIQUE mine_name_unique (name, deleted_at)");
        $this->forge->createTable('mine', true);
        
        // Creating table mining_record
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'vehicle_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'mine_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'depot_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'amount'        => ['type' => 'DECIMAL', 'constraint' => '8,4', 'unsigned' => true, 'default' => 0.0],
            'rate'          => ['type' => 'DECIMAL', 'constraint' => '8,2', 'unsigned' => true, 'default' => 0.0],
            'price'         => ['type' => 'DECIMAL(8,2) AS (`amount`*`rate`) VIRTUAL', 'null' => true],
            'expenses'      => ['type' => 'JSON', 'default' => '{}'],
            // gross column in select output
            'date'          => ['type' => 'DATE'],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('vehicle_id', 'vehicles', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('mine_id', 'mine', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('depot_id', 'depot', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addField("CONSTRAINT `mining_record_expenses_check` CHECK(JSON_VALID(`expenses`))");
        $this->forge->createTable('mining_record', true);
        
        // Create mining_record triggers
        $this->db->simpleQuery(""
                . "CREATE TRIGGER `mining_record_insert_depot` AFTER INSERT ON `mining_record` FOR EACH ROW\n"
                . "UPDATE `depot` SET depot.rawamt = depot.rawamt + NEW.amount WHERE depot.id = NEW.depot_id");
        $this->db->simpleQuery(""
                . "CREATE TRIGGER `mining_record_update_depot` AFTER UPDATE ON `mining_record` FOR EACH ROW\n"
                . "BEGIN\n"
                . "     IF OLD.depot_id = NEW.depot_id THEN\n"
                . "         UPDATE `depot` SET depot.rawamt = depot.rawamt - OLD.amount + NEW.amount WHERE depot.id = NEW.depot_id;\n"
                . "     ELSE\n"
                . "         UPDATE `depot` o, `depot` n SET o.rawamt = o.rawamt - OLD.amount, n.rawamt = n.rawamt + NEW.amount "
                . "             WHERE o.id = OLD.depot_id AND n.id = NEW.depot_id;\n"
                . "     END IF;\n"
                . "END;");
        $this->db->simpleQuery(""
                . "CREATE TRIGGER `mining_record_delete_depot` AFTER DELETE ON `mining_record` FOR EACH ROW\n"
                . "BEGIN\n"
                . "     IF DATEDIFF(CURDATE(), OLD.updated_at) <= 365 THEN\n"
                . "         UPDATE `depot` SET depot.rawamt = depot.rawamt - OLD.amount WHERE depot.id = OLD.depot_id;\n"
                . "     END IF;\n"
                . "END;");
        
        // Creating table renters
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'profession'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'phone'         => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'address'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'city'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'state'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'country'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'area_pin'      => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'details'       => ['type' => 'JSON', 'null' => true, 'default' => '{}'],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true],
            'deleted_at'    => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("CONSTRAINT `renters_details_check` CHECK(JSON_VALID(`details`))");
        $this->forge->createTable('renters', true);
        
        // Creating table coal_customers
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'corpname'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'phone'     => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'email'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'gstin'     => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'address'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'city'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'state'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'country'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'area_pin'  => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'details'   => ['type' => 'JSON', 'null' => true, 'default' => '{}'],
            'created_at'=> ['type' => 'datetime', 'null' => true],
            'updated_at'=> ['type' => 'datetime', 'null' => true],
            'deleted_at'=> ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("CONSTRAINT `coal_customers_details_check` CHECK(JSON_VALID(`details`))");
        $this->forge->createTable('coal_customers', true);
        
        // Creating table coal_suppliers
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'corpname'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'phone'     => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'email'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'gstin'     => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'address'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'city'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'state'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'country'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'area_pin'  => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'details'   => ['type' => 'JSON', 'null' => true, 'default' => '{}'],
            'renter_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'=> ['type' => 'datetime', 'null' => true],
            'updated_at'=> ['type' => 'datetime', 'null' => true],
            'deleted_at'=> ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("CONSTRAINT `coal_suppliers_details_check` CHECK(JSON_VALID(`details`))");
        $this->forge->addForeignKey('renter_id', 'renters', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('coal_suppliers', true);
        
        // Creating table coal_purchased_record
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'supplier_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'depot_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'amount'        => ['type' => 'DECIMAL', 'constraint' => '8,4', 'unsigned' => true, 'default' => 0.0],
            'rate'          => ['type' => 'DECIMAL', 'constraint' => '8,2', 'unsigned' => true, 'default' => 0.0],
            'price'         => ['type' => 'DECIMAL(8,2) AS (`amount`*`rate`) VIRTUAL', 'null' => true],
            'is_processed'  => ['type' => 'BOOLEAN', 'default' => false],
            'date'          => ['type' => 'DATE'],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('supplier_id', 'coal_suppliers', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('depot_id', 'depot', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('coal_purchased_record', true);
        
         // Create coal_purchased_record triggers
        $this->db->simpleQuery(""
                . "CREATE TRIGGER `coal_purchased_record_insert_depot` AFTER INSERT ON `coal_purchased_record` FOR EACH ROW\n"
                . "UPDATE `depot` SET depot.rawamt =  depot.rawamt + IF(NEW.is_processed, 0, NEW.amount), "
                . "depot.cookamt =  depot.cookamt + IF(NEW.is_processed, NEW.amount, 0) WHERE depot.id = NEW.depot_id");
        $this->db->simpleQuery(""
                . "CREATE TRIGGER `coal_purchased_record_update_depot` AFTER UPDATE ON `coal_purchased_record` FOR EACH ROW\n"
                . "BEGIN\n"
                . "     IF OLD.depot_id = NEW.depot_id THEN\n"
                . "         IF OLD.is_processed = NEW.is_processed THEN\n"
                . "             UPDATE `depot` d SET d.rawamt =  d.rawamt + IF(NEW.is_processed, 0, (NEW.amount - OLD.amount)), "
                . "                 d.cookamt =  d.cookamt + IF(NEW.is_processed, (NEW.amount - OLD.amount), 0) WHERE d.id = NEW.depot_id;\n"
                . "         ELSEIF OLD.is_processed = 0 AND NEW.is_processed = 1 THEN\n"
                . "             UPDATE `depot` d SET d.rawamt = d.rawamt - OLD.amount, d.cookamt = d.cookamt + NEW.amount "
                . "                 WHERE d.id = NEW.depot_id;\n"
                . "         ELSEIF OLD.is_processed = 1 AND NEW.is_processed = 0 THEN\n"
                . "             UPDATE `depot` d SET d.rawamt = d.rawamt + NEW.amount, d.cookamt = d.cookamt - OLD.amount "
                . "                 WHERE d.id = NEW.depot_id;\n"
                . "         END IF;\n"
                . "     ELSE\n"
                . "         IF OLD.is_processed = NEW.is_processed THEN\n"
                . "             IF NEW.is_processed THEN\n"
                . "                 UPDATE `depot` o, `depot` n SET o.cookamt = o.cookamt - OLD.amount, n.cookamt =  n.cookamt + NEW.amount "
                . "                     WHERE o.id = OLD.depot_id AND n.id = NEW.depot_id;\n"
                . "             ELSE\n"
                . "                 UPDATE `depot` o, `depot` n SET o.rawamt = o.rawamt - OLD.amount, n.rawamt = n.rawamt + NEW.amount "
                . "                     WHERE o.id = OLD.depot_id AND n.id = NEW.depot_id;\n"
                . "             END IF;\n"
                . "         ELSEIF OLD.is_processed = 0 AND NEW.is_processed = 1 THEN\n"
                . "             UPDATE `depot` o, `depot` n SET o.rawamt = o.rawamt - OLD.amount, n.cookamt = n.cookamt + NEW.amount "
                . "                     WHERE o.id = OLD.depot_id AND n.id = NEW.depot_id;\n"
                . "         ELSEIF OLD.is_processed = 1 AND NEW.is_processed = 0 THEN\n"
                . "             UPDATE `depot` o, `depot` n SET o.cookamt = o.cookamt - OLD.amount, n.rawamt = n.rawamt + NEW.amount "
                . "                     WHERE o.id = OLD.depot_id AND n.id = NEW.depot_id;\n"
                . "         END IF;\n"
                . "     END IF;\n"
                . "END;");
        $this->db->simpleQuery(""
                . "CREATE TRIGGER `coal_purchased_record_delete_depot` AFTER DELETE ON `coal_purchased_record` FOR EACH ROW\n"
                . "BEGIN\n"
                . "     IF DATEDIFF(CURDATE(), OLD.updated_at) <= 365 THEN\n"
                . "         UPDATE `depot` d SET d.rawamt = d.rawamt - IF(OLD.is_processed, 0, OLD.amount), "
                . "         d.cookamt =  d.cookamt - IF(OLD.is_processed, OLD.amount, 0) WHERE d.id = OLD.depot_id;\n"
                . "     END IF;\n"
                . "END;");
        
        // Creating table coal_sold_record
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'buyer_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'depot_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'amount'        => ['type' => 'DECIMAL', 'constraint' => '8,4', 'unsigned' => true, 'default' => 0.0],
            'rate'          => ['type' => 'DECIMAL', 'constraint' => '8,2', 'unsigned' => true, 'default' => 0.0],
            'price'         => ['type' => 'DECIMAL(8,2) AS (`amount`*`rate`) VIRTUAL', 'null' => true],
            'is_processed'  => ['type' => 'BOOLEAN', 'default' => false],
            'date'          => ['type' => 'DATE'],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('buyer_id', 'coal_customers', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('depot_id', 'depot', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('coal_sold_record', true);
        
        // Create coal_sold_record triggers
        $this->db->simpleQuery(""
                . "CREATE TRIGGER `coal_sold_record_insert_depot` AFTER INSERT ON `coal_sold_record` FOR EACH ROW\n"
                . "UPDATE `depot` SET depot.rawamt =  depot.rawamt - IF(NEW.is_processed, 0, NEW.amount), "
                . "depot.cookamt =  depot.cookamt - IF(NEW.is_processed, NEW.amount, 0) WHERE depot.id = NEW.depot_id");
        $this->db->simpleQuery(""
                . "CREATE TRIGGER `coal_sold_record_update_depot` AFTER UPDATE ON `coal_sold_record` FOR EACH ROW\n"
                . "BEGIN\n"
                . "     IF OLD.depot_id = NEW.depot_id THEN\n"
                . "         IF OLD.is_processed = NEW.is_processed THEN\n"
                . "             UPDATE `depot` d SET d.rawamt =  d.rawamt - IF(NEW.is_processed, 0, (NEW.amount - OLD.amount)), "
                . "                 d.cookamt =  d.cookamt - IF(NEW.is_processed, (NEW.amount - OLD.amount), 0) WHERE d.id = NEW.depot_id;\n"
                . "         ELSEIF OLD.is_processed = 0 AND NEW.is_processed = 1 THEN\n"
                . "             UPDATE `depot` d SET d.rawamt = d.rawamt + OLD.amount, d.cookamt = d.cookamt - NEW.amount "
                . "                 WHERE d.id = NEW.depot_id;\n"
                . "         ELSEIF OLD.is_processed = 1 AND NEW.is_processed = 0 THEN\n"
                . "             UPDATE `depot` d SET d.rawamt = d.rawamt - NEW.amount, d.cookamt = d.cookamt + OLD.amount "
                . "                 WHERE d.id = NEW.depot_id;\n"
                . "         END IF;\n"
                . "     ELSE\n"
                . "         IF OLD.is_processed = NEW.is_processed THEN\n"
                . "             IF NEW.is_processed THEN\n"
                . "                 UPDATE `depot` o, `depot` n SET o.cookamt = o.cookamt + OLD.amount, n.cookamt =  n.cookamt - NEW.amount "
                . "                     WHERE o.id = OLD.depot_id AND n.id = NEW.depot_id;\n"
                . "             ELSE\n"
                . "                 UPDATE `depot` o, `depot` n SET o.rawamt = o.rawamt + OLD.amount, n.rawamt =  n.rawamt - NEW.amount "
                . "                     WHERE o.id = OLD.depot_id AND n.id = NEW.depot_id;\n"
                . "             END IF;\n"
                . "         ELSEIF OLD.is_processed = 0 AND NEW.is_processed = 1 THEN\n"
                . "             UPDATE `depot` o, `depot` n SET o.rawamt = o.rawamt + OLD.amount, n.cookamt = n.cookamt - NEW.amount "
                . "                     WHERE o.id = OLD.depot_id AND n.id = NEW.depot_id;\n"
                . "         ELSEIF OLD.is_processed = 1 AND NEW.is_processed = 0 THEN\n"
                . "             UPDATE `depot` o, `depot` n SET o.cookamt = o.cookamt + OLD.amount, n.rawamt = n.rawamt - NEW.amount "
                . "                     WHERE o.id = OLD.depot_id AND n.id = NEW.depot_id;\n"
                . "         END IF;\n"
                . "     END IF;\n"
                . "END;");
        $this->db->simpleQuery(""
                . "CREATE TRIGGER `coal_sold_record_delete_depot` AFTER DELETE ON `coal_sold_record` FOR EACH ROW\n"
                . "BEGIN\n"
                . "     IF DATEDIFF(CURDATE(), OLD.updated_at) <= 365 THEN\n"
                . "         UPDATE `depot` SET depot.rawamt = depot.rawamt + IF(OLD.is_processed, 0, OLD.amount), "
                . "         depot.cookamt =  depot.cookamt + IF(OLD.is_processed, OLD.amount, 0) WHERE depot.id = OLD.depot_id;\n"
                . "     END IF;\n"
                . "END;");
        
        // Creating table coal_processed_record
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'depotin_id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'depotout_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'amount_in'         => ['type' => 'DECIMAL', 'constraint' => '8,4', 'unsigned' => true, 'default' => 0.0],
            'amount_out'        => ['type' => 'DECIMAL', 'constraint' => '8,4', 'unsigned' => true, 'default' => 0.0],
            'expenses'          => ['type' => 'JSON', 'default' => '{}'],
            'date'              => ['type' => 'DATE'],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('depotin_id', 'depot', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('depotout_id', 'depot', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addField("CONSTRAINT `coal_processed_record_expenses_check` CHECK(JSON_VALID(`expenses`))");
        $this->forge->createTable('coal_processed_record', true);
        
        // Create coal_processed_record triggers
        $this->db->simpleQuery(""
                . "CREATE TRIGGER `coal_processed_record_insert_depot` AFTER INSERT ON `coal_processed_record` FOR EACH ROW\n"
                . "UPDATE `depot` i, `depot` o SET i.rawamt =  i.rawamt - NEW.amount_in, "
                . "o.cookamt = o.cookamt + NEW.amount_out WHERE i.id = NEW.depotin_id AND o.id = NEW.depotout_id");
        $this->db->simpleQuery(""
                . "CREATE TRIGGER `coal_processed_record_update_depot` AFTER UPDATE ON `coal_processed_record` FOR EACH ROW\n"
                . "BEGIN\n"
                . "     UPDATE `depot` i, `depot` o SET i.rawamt = i.rawamt + OLD.amount_in, "
                . "         o.cookamt =  o.cookamt - OLD.amount_out WHERE i.id = OLD.depotin_id AND o.id = OLD.depotout_id;\n"
                . "     UPDATE `depot` i, `depot` o SET i.rawamt = i.rawamt - NEW.amount_in , "
                . "         o.cookamt =  o.cookamt + NEW.amount_out WHERE i.id = NEW.depotin_id AND o.id = NEW.depotout_id;\n"
                . "END;");
        $this->db->simpleQuery(""
                . "CREATE TRIGGER `coal_processed_record_delete_depot` AFTER DELETE ON `coal_processed_record` FOR EACH ROW\n"
                . "BEGIN\n"
                . "     IF DATEDIFF(CURDATE(), OLD.updated_at) <= 365 THEN\n"
                . "         UPDATE `depot` i, `depot` o SET i.rawamt = i.rawamt + OLD.amount_in, "
                . "         o.cookamt =  o.cookamt - OLD.amount_out WHERE i.id = OLD.depotout_id AND o.id = OLD.depotout_id;\n"
                . "     END IF;\n"
                . "END;");
        
        // Creating table asset_types
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at'=> ['type' => 'datetime', 'null' => true],
            'updated_at'=> ['type' => 'datetime', 'null' => true],
            'deleted_at'=> ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("UNIQUE asset_types_name_unique (name, deleted_at)");
        $this->forge->createTable('asset_types', true);
        
        // Creating table assets_record
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'newstock'      => ['type' => 'BOOLEAN', 'default' => false],
            'type_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'amount'        => ['type' => 'DECIMAL', 'constraint' => '8,4', 'unsigned' => true, 'default' => 0.0],
            'rate'          => ['type' => 'DECIMAL', 'constraint' => '8,2', 'unsigned' => true, 'default' => 0.0],
            'cost'          => ['type' => 'DECIMAL(8,2) AS (`amount`*`rate`) VIRTUAL', 'null' => true],
            'usedamt'       => ['type' => 'DECIMAL', 'constraint' => '8,4', 'unsigned' => true, 'default' => 0.0],
            'stockamt'      => ['type' => 'DECIMAL(8,4) AS (IF(`newstock`, (`amount` - `usedamt`), (-`usedamt`))) VIRTUAL', 'null' => true],
            'depot_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'details'       => ['type' => 'JSON', 'null' => true, 'default' => '{}'],
            'desc'          => ['type' => 'TEXT', 'null' => true],
            'date'          => ['type' => 'DATE'],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('type_id', 'asset_types', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('depot_id', 'depot', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addField("CONSTRAINT `assets_record_details_check` CHECK(JSON_VALID(`details`))");
        $this->forge->createTable('assets_record', true);
        
        // Create table stat_assets
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'type_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'depot_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'amount'        => ['type' => 'DECIMAL', 'constraint' => '8,4', 'default' => 0.0]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("UNIQUE asset_types_name_unique (type_id, depot_id)");
        $this->forge->addForeignKey('type_id', 'asset_types', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('depot_id', 'depot', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('stat_assets', true);
        
        // Create trigger for assets_record
        $this->db->simpleQuery(""
                . "CREATE TRIGGER `assets_record_insert_stat_assets` AFTER INSERT ON `assets_record` FOR EACH ROW\n"
                . "BEGIN\n"
                . "     IF EXISTS(SELECT s.type_id FROM stat_assets s WHERE s.type_id = NEW.type_id AND s.depot_id = NEW.depot_id) THEN\n"
                . "         UPDATE stat_assets s SET s.amount = s.amount + NEW.stockamt WHERE s.type_id = NEW.type_id AND s.depot_id = NEW.depot_id;"
                . "     ELSE\n"
                . "         IF NEW.newstock THEN\n"
                . "             INSERT INTO stat_assets (type_id, depot_id, amount) VALUES (NEW.type_id, NEW.depot_id, NEW.stockamt);\n"
                . "         END IF;\n"
                . "     END IF;\n"
                . "END;");
        $this->db->simpleQuery(""
                . "CREATE TRIGGER `assets_record_update_stat_assets` AFTER UPDATE ON `assets_record` FOR EACH ROW\n"
                . "BEGIN\n"
                . "     IF (OLD.type_id = NEW.type_id AND OLD.depot_id = NEW.depot_id) THEN\n"
                . "         UPDATE stat_assets s SET s.amount = s.amount - OLD.stockamt + NEW.stockamt WHERE s.type_id = NEW.type_id AND s.depot_id = NEW.depot_id;\n"
                . "     ELSE\n"
                . "         IF EXISTS(SELECT s.type_id FROM stat_assets s WHERE s.type_id = NEW.type_id AND s.depot_id = NEW.depot_id) THEN\n"
                . "             UPDATE stat_assets s SET s.amount = s.amount + NEW.stockamt WHERE s.type_id = NEW.type_id AND s.depot_id = NEW.depot_id;\n"
                . "         ELSE\n"
                . "             INSERT INTO stat_assets (type_id, depot_id, amount) VALUES (NEW.type_id, NEW.depot_id, NEW.stockamt);\n"
                . "         END IF;\n"
                . "         IF (SELECT s.amount FROM stat_assets s WHERE s.type_id = OLD.type_id AND s.depot_id = OLD.depot_id) - OLD.stockamt = 0 THEN\n"
                . "             DELETE FROM stat_assets WHERE type_id = OLD.type_id AND depot_id = OLD.depot_id;\n"
                . "         ELSE\n"
                . "             UPDATE stat_assets s SET s.amount = s.amount - OLD.stockamt WHERE s.type_id = OLD.type_id AND s.depot_id = OLD.depot_id;\n"
                . "         END IF;\n"
                . "     END IF;\n"
                . "END;");
        $this->db->simpleQuery(""
                . "CREATE TRIGGER `assets_record_delete_stat_assets` AFTER DELETE ON `assets_record` FOR EACH ROW\n"
                . "BEGIN\n"
                . "     IF DATEDIFF(CURDATE(), OLD.updated_at) <= 365 THEN\n"
                . "         UPDATE stat_assets s SET s.amount = s.amount - OLD.stockamt WHERE s.type_id = OLD.type_id AND s.depot_id = OLD.depot_id;\n"
                . "     END IF;\n"
                . "     IF (SELECT s.amount FROM stat_assets s WHERE s.type_id = OLD.type_id AND s.depot_id = OLD.depot_id) - OLD.stockamt = 0 THEN\n"
                . "         DELETE FROM stat_assets WHERE type_id = OLD.type_id AND depot_id = OLD.depot_id;\n"
                . "     END IF;\n"
                . "END;");
        
        // Creating table rent_record
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'vehicle_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'renter_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'cost_fuel'     => ['type' => 'DECIMAL', 'constraint' => '8,2', 'unsigned' => true, 'default' => 0.0],
            'daily_price'   => ['type' => 'DECIMAL', 'constraint' => '8,2', 'unsigned' => true, 'default' => 0.0],
            'driver_wages'  => ['type' => 'DECIMAL', 'constraint' => '8,2', 'unsigned' => true, 'default' => 0.0],
            'days_ex'       => ['type' => 'INT', 'constraint' => 2, 'unsigned' => true],
            'date_return'   => ['type' => 'DATE', 'null' => true],
            'netamt'        => ['type' => 'DECIMAL(8,2) AS (IF(`date_return` IS NULL, '
                . '((DATEDIFF(CURDATE(), `date`) + 1 -`days_ex`) * (`daily_price`+`driver_wages`+`cost_fuel`)), '
                . '((DATEDIFF(`date_return`,`date`) + 1 -`days_ex`) * (`daily_price`+`driver_wages`+`cost_fuel`)))) VIRTUAL', 'null' => true],
            'paidamt'       => ['type' => 'DECIMAL', 'constraint' => '8,2', 'unsigned' => true, 'default' => 0.0],
            'remainamt'     => ['type' => 'DECIMAL(8,2) AS (`netamt`-`paidamt`) VIRTUAL', 'null' => true],
            'paid'          => ['type' => 'BOOLEAN AS (`netamt` = `paidamt`) VIRTUAL', 'null' => true],
            'bycoal'        => ['type' => 'BOOLEAN AS (cpr_id IS NOT NULL) VIRTUAL', 'null' => true],
            'returned'      => ['type' => 'BOOLEAN AS (date_return IS NOT NULL) VIRTUAL', 'null' => true],
            'cpr_id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'date'          => ['type' => 'DATE'],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('date_return');
        $this->forge->addForeignKey('vehicle_id', 'vehicles', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('renter_id', 'renters', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('cpr_id', 'coal_purchased_record', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('rent_record', true);
        
        // Creating table department_types
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at'=> ['type' => 'datetime', 'null' => true],
            'updated_at'=> ['type' => 'datetime', 'null' => true],
            'deleted_at'=> ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("UNIQUE department_types_name_unique (name, deleted_at)");
        $this->forge->createTable('department_types', true);
        
        // Creating table employees 
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'              => ['type' => 'VARCHAR', 'constraint' => 100],
            'designation'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'department_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'phone'             => ['type' => 'VARCHAR', 'constraint' => 20],
            'email'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'city'              => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'address'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'state'             => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'country'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'area_pin'          => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'salary_type'       => ['type' => 'ENUM', 'constraint' => ['DAILY', 'WEEKLY', 'MONTHLY'], 'default' => 'MONTHLY'],
            'salary_amt'        => ['type' => 'DECIMAL', 'constraint' => '8,2', 'unsigned' => true, 'default' => 0.0],
            'date'              => ['type' => 'DATE'],
            'date_leaving'      => ['type' => 'DATE', 'null' => true],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_at'        => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("UNIQUE employees_phone_unique (phone, deleted_at)");
        $this->forge->addForeignKey('department_id', 'department_types', 'id', 'CASCADE', false);
        $this->forge->createTable('employees', true);
        
        // Creating table attendance_record
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'employee_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'is_present'    => ['type' => 'BOOLEAN', 'default' => false],
            'reason'        => ['type' => 'TEXT', 'null' => true, 'default' => null],
            'date'          => ['type' => 'DATE'],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("UNIQUE attendance_record_unique (`employee_id`, `date`)");
        $this->forge->addForeignKey('employee_id', 'employees', 'id', 'CASCADE', false);
        $this->forge->createTable('attendance_record', true);
        
        // Creating table payroll_record
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'employee_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'attendance'    => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],
            'payamt'        => ['type' => 'DECIMAL', 'constraint' => '8,2', 'unsigned' => true, 'default' => 0.0],
            'timeamt'       => ['type' => 'DECIMAL', 'constraint' => '5,4', 'unsigned' => true, 'default' => 1],
            'tax'           => ['type' => 'DECIMAL', 'constraint' => '8,2', 'unsigned' => true, 'default' => 0.0],
            'addjson'       => ['type' => 'JSON', 'default' => '{}'],
            'dedjson'       => ['type' => 'JSON', 'default' => '{}'],
            'date'          => ['type' => 'DATE'],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('employee_id', 'employees', 'id', 'CASCADE', false);
        $this->forge->addField("CONSTRAINT `payroll_record_addjson_check` CHECK(JSON_VALID(`addjson`))");
        $this->forge->addField("CONSTRAINT `payroll_record_dedjson_check` CHECK(JSON_VALID(`dedjson`))");
        $this->forge->createTable('payroll_record', true);
    }
    
    public function down()
    {
        // Reject if not mysql
        if ($this->db->DBDriver != 'MySQLi')
        {
            echo 'This website is intented to work only with MySQL databases!';
            return;
        }
        // Remove triggers
        $this->db->simpleQuery("DROP TRIGGER `mining_record_insert_depot`;");
        $this->db->simpleQuery("DROP TRIGGER `mining_record_update_depot`;");
        $this->db->simpleQuery("DROP TRIGGER `mining_record_delete_depot`;");
        $this->db->simpleQuery("DROP TRIGGER `coal_purchased_record_insert_depot`;");
        $this->db->simpleQuery("DROP TRIGGER `coal_purchased_record_update_depot`;");
        $this->db->simpleQuery("DROP TRIGGER `coal_purchased_record_delete_depot`;");
        $this->db->simpleQuery("DROP TRIGGER `coal_sold_record_insert_depot`;");
        $this->db->simpleQuery("DROP TRIGGER `coal_sold_record_update_depot`;");
        $this->db->simpleQuery("DROP TRIGGER `coal_sold_record_delete_depot`;");
        $this->db->simpleQuery("DROP TRIGGER `coal_processed_record_insert_depot`;");
        $this->db->simpleQuery("DROP TRIGGER `coal_processed_record_update_depot`;");
        $this->db->simpleQuery("DROP TRIGGER `coal_processed_record_delete_depot`;");
        $this->db->simpleQuery("DROP TRIGGER `assets_record_insert_stat_assets`;");
        $this->db->simpleQuery("DROP TRIGGER `assets_record_delete_stat_assets`;");
        $this->db->simpleQuery("DROP TRIGGER `assets_record_update_stat_assets`;");
        
        // Remove foreign keys
        $this->forge->dropForeignKey('mining_record', 'mining_record_vehicle_id_foreign');
        $this->forge->dropForeignKey('mining_record', 'mining_record_mine_id_foreign');
        $this->forge->dropForeignKey('mining_record', 'mining_record_depot_id_foreign');
        $this->forge->dropForeignKey('coal_suppliers', 'coal_suppliers_renter_id_foreign');
        $this->forge->dropForeignKey('coal_purchased_record', 'coal_purchased_record_supplier_id_foreign');
        $this->forge->dropForeignKey('coal_purchased_record', 'coal_purchased_record_depot_id_foreign');
        $this->forge->dropForeignKey('coal_sold_record', 'coal_sold_record_buyer_id_foreign');
        $this->forge->dropForeignKey('coal_sold_record', 'coal_sold_record_depot_id_foreign');
        $this->forge->dropForeignKey('coal_processed_record', 'coal_processed_record_depotin_id_foreign');
        $this->forge->dropForeignKey('coal_processed_record', 'coal_processed_record_depotout_id_foreign');
        $this->forge->dropForeignKey('assets_record', 'assets_record_type_id_foreign');
        $this->forge->dropForeignKey('assets_record', 'assets_record_depot_id_foreign');
        $this->forge->dropForeignKey('stat_assets', 'stat_assets_type_id_foreign');
        $this->forge->dropForeignKey('stat_assets', 'stat_assets_depot_id_foreign');
        $this->forge->dropForeignKey('rent_record', 'rent_record_vehicle_id_foreign');
        $this->forge->dropForeignKey('rent_record', 'rent_record_renter_id_foreign');
        $this->forge->dropForeignKey('rent_record', 'rent_record_cpr_id_foreign');
        $this->forge->dropForeignKey('employees', 'employees_department_id_foreign');
        $this->forge->dropForeignKey('attendance_record', 'attendance_record_employee_id_foreign');
        $this->forge->dropForeignKey('payroll_record', 'payroll_record_employee_id_foreign');

        // Removing tables
        $this->forge->dropTable('vehicles', true);
        $this->forge->dropTable('mine', true);
        $this->forge->dropTable('depot', true);
        $this->forge->dropTable('mining_record', true);

        $this->forge->dropTable('coal_customers', true);
        $this->forge->dropTable('coal_suppliers', true);
        $this->forge->dropTable('coal_purchased_record', true);
        $this->forge->dropTable('coal_sold_record', true);
        $this->forge->dropTable('coal_processed_record', true);

        $this->forge->dropTable('asset_types', true);
        $this->forge->dropTable('assets_record', true);
        $this->forge->dropTable('stat_assets', true);

        $this->forge->dropTable('renters', true);
        $this->forge->dropTable('rent_record', true);

        $this->forge->dropTable('department_types', true);
        $this->forge->dropTable('employees', true);
        $this->forge->dropTable('attendance_record', true);
        $this->forge->dropTable('payroll_record', true);
        
        // Remove created functions
        $this->db->simpleQuery("DROP FUNCTION JSON_ARRSUM;");
    }
}
