CREATE TABLE User (
    UserId INT PRIMARY KEY,
    Name VARCHAR(255),
    Username VARCHAR(255),
    Age INT,
    Gender VARCHAR(10),
    Height FLOAT,
    Weight FLOAT,
    BMI FLOAT,
    Email VARCHAR(255),
    Password VARCHAR(255),
    Status VARCHAR(50)
);


CREATE TABLE Admin (
    AdminId INT PRIMARY KEY,
    Name VARCHAR(255),
    Email VARCHAR(255),
    Password VARCHAR(255),
    Status VARCHAR(50)
);

CREATE TABLE Exercise (
    ExerciseId INT PRIMARY KEY,
    Name VARCHAR(255),
    Category VARCHAR(255),
    Description TEXT,
    Link VARCHAR(255),
    AdminId INT,
    FOREIGN KEY (AdminId) REFERENCES Admin(AdminId)
);


CREATE TABLE Goals (
    GoalsId INT PRIMARY KEY,
    Name VARCHAR(255)
);

CREATE TABLE Goal_Exercise (
    GoalsId INT,
    ExerciseId INT,
    PRIMARY KEY (GoalsId, ExerciseId),
    FOREIGN KEY (GoalsId) REFERENCES Goals(GoalsId),
    FOREIGN KEY (ExerciseId) REFERENCES Exercise(ExerciseId)
);


CREATE TABLE Recipe (
    RecipeId INT PRIMARY KEY,
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
