CREATE TABLE User (
    UserId INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255),
    Username VARCHAR(255),
    Date_Of_Birth VARCHAR(10),
    Gender VARCHAR(10),
    Height FLOAT,
    Weight FLOAT,
    BMI FLOAT,
    Email VARCHAR(255),
    Password VARCHAR(255),
    Status VARCHAR(50)
);


CREATE TABLE Admin (
    AdminId INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255),
    Email VARCHAR(255),
    Password VARCHAR(255),
    Status VARCHAR(50)
);



CREATE TABLE Goal (
    GoalId INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255)
);


CREATE TABLE Recipe (
    RecipeId INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255),
    Ingredient TEXT,
    Description TEXT,
    AdminId INT,
    FOREIGN KEY (AdminId) REFERENCES Admin(AdminId)
);

CREATE TABLE User_Recipe (
    UserId INT,
    RecipeId INT,
    PRIMARY KEY (UserId, RecipeId),
    FOREIGN KEY (UserId) REFERENCES User(UserId),
    FOREIGN KEY (RecipeId) REFERENCES Recipe(RecipeId)
);

CREATE TABLE Contact_Us (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL
);

CREATE TABLE Exercise (
    ExerciseId INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255),
    Description TEXT,
    Link VARCHAR(255),
    AdminId INT,
    GoalId INT,
    FOREIGN KEY (GoalId) REFERENCES Goal(GoalId),
    FOREIGN KEY (AdminId) REFERENCES Admin(AdminId)
);


