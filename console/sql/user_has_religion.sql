-- Menambahkan Foreign Key untuk religion_id di tabel users
ALTER TABLE `users`
    ADD CONSTRAINT `fk-user-religion_id`
        FOREIGN KEY (`religion_id`)
            REFERENCES `religions`(`id`)
            ON UPDATE CASCADE;
