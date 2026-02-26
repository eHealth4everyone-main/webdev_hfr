UPDATE users SET password = '$2y$10$0I8icjRh6qpqgDr7QTYRcuK/CrlQ.6qIDiLFUJNwlII5nsSpsgMK', status = 1 WHERE username = 'admin' OR email LIKE 'admin%';
