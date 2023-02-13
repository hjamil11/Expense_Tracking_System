CREATE TABLE user (
    username TEXT NOT NULL,
    email TEXT UNIQUE PRIMARY KEY,
    dob TEXT NOT NULL,
    password TEXT NOT NULL
);

CREATE TABLE log (
    id INTEGER UNIQUE PRIMARY KEY,
    email TEXT NOT NULL,
    description TEXT NOT NULL,
    paid REAL NOT NULL,
    date TEXT NOT NULL,
    location TEXT NOT NULL
);