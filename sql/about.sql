
/*For about.html, here is an example. I didnt test it, so please change it */
CREATE TABLE contributions (
    member_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    student_id VARCHAR(20) NOT NULL,
    role VARCHAR(50) NOT NULL,
    contributions_part1 TEXT NOT NULL,
    contributions_part2 TEXT NOT NULL,
    quote_ar VARCHAR(255) NOT NULL,
    quote_en VARCHAR(255) NOT NULL,

);

