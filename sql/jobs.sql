/*For jobs.php, here is an example. I didnt test it, so please change it */
DROP TABLE IF EXISTS jobs;
CREATE TABLE jobs (
    job_reference VARCHAR(5) PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    salary VARCHAR(100) NOT NULL,
    reports_to VARCHAR(100) NOT NULL,
    key_responsibilities TEXT NOT NULL,
    essential_requirements TEXT NOT NULL,
    preferable_requirements TEXT NOT NULL,
    closing_date DATE NOT NULL
);
