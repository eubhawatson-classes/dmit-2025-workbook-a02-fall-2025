/*

    UPDATE and DELETE are the U and D part of CRUD. They are the most dangerous.

    The syntax for UPDATE looks like: 

    UPDATE table_name 
    SET column_1 = value1, column_2 = value2 ...
    WHERE condition;

*/

-- The SET command is used with UPDATE to specify which olumns and values should be updated in a table.
UPDATE cities SET city_name = 'Trana' WHERE cid = 1; 

-- Here, we're adding 10000 to the populations of any city in Alberta or Saskatchewan.
UPDATE cities SET population = population + 10000 WHERE province = 'AB' OR province = 'SK';

/*
    The syntax for DELETE looks like: 

    DELETE FROM table_name WHERE condition;

    Remember that this operation is permanent. There is no undo.
*/

-- Here, we're getting rid of the 16th city in our table.
DELETE FROM cities WHERE cid = 16;

-- And here, we're getting rid of any city with a population less than 10,000.
DELETE FROM cities WHERE population < 10000;