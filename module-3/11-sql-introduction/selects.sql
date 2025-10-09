/*
    The SELECT command is what allows up to 'read' or retrieve data. Its syntax looks like the following: 

    SELECT column_name FROM table_name;
*/

-- In our cities example, we could run: 
SELECT city_name FROM cities;
-- This would return all of the names (but nothing else).

-- But maybe I want the first three records, in full. 
SELECT * FROM cities LIMIT 3;

-- Now, what if we want a very specific city? 
SELECT * FROM cities WHERE cid = 6;
-- Here, the WHERE clause is adding a condition. 

-- This would select every city in our table from Ontario.
SELECT * FROM cities WHERE province = 'ON';

-- What if we wanted all of the capital cities? 
SELECT * FROM cities WHERE is_capital = TRUE;

-- In our table, this column is a BOOLEAN value. It is stored as either a 0 or a 1. We could also use these values to return the exact same results. 
SELECT * FROM cities WHERE is_capital = 1;

-- LIKE lets us look for a pattern in our data. 
SELECT * FROM cities WHERE city_name LIKE '%john%';
-- The % is a wildcard. It allows us to match any string of any length (including 0).

-- We can string multiple conditions together with logical operators, like AND.
SELECT * FROM cities WHERE province = 'ON' AND population > 1000000;

-- And we can list our results any way we like. Here, we're listing them in descending order.
SELECT * FROM cities WHERE province = 'ON' ORDER BY population DESC;

-- What if we want to know which city has the smallest population?
SELECT city_name, population FROM cities ORDER BY population ASC LIMIT 1;

-- We can also offset our limited results. What if, instead of the top 3 most populated cities, I wanted the next three most populated cities?
SELECT population, city_name FROM cities ORDER BY population DESC LIMIT 3, 3;
-- By adding a comma and number after the limit, the system knows to start getting records from there. 

/*

    This is a 'Canadian Cities' database, but we actually have cities, towns, and villages. They're each defined by their population size, as follows: 

        1. City - 10,000 people or greater
        2. Town - 1,000 people or greater
        3. Village - 300 people or greater

*/

-- So, how might we select only cities? 
SELECT city_name, population FROM cities WHERE population >= 10000;

-- What about only towns? 
SELECT city_name, population FROM cities WHERE population >= 1000 AND population < 10000;

-- And only villages? 
SELECT city_name, population FROM cities WHERE population >= 300 AND population < 1000;

-- We could also use the BETWEEN clause.
SELECT city_name, population FROM cities WHERE population BETWEEN 300 AND 999;