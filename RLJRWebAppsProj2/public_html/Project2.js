/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function Course(name, ID, credits, semester) {
    this.name = name;
    this.ID = ID;
    this.credits = credits;
    this.semester = semester;
    this.history = false;
}

function Year(){
    this.fa = {};
    this.sp = {};
    this.su = {};
}

function Plan(plan_name, catalog_year, major, student_name, current_semester, courses) {
    this.plan_name = plan_name;
    this.catalog_year = catalog_year;
    this.major = major;
    this.student_name = student_name;
    this.current_semester = current_semester;
    this.courses = courses;
}



var courses = [
    new Course("C++ Programming", "CS-1210", 2, "FA2014"),
    new Course("Making of the Modern Mind", "HON-1010", 5, "FA2014"),
    new Course("Digital Logic Design", "EGCP-1010", 3, "FA2014"),
    new Course("Calculus 1", "MATH-1710", 5, "FA2014"),
    new Course("Engineering Profession", "EGGN-1110", 1, "FA2014"),
    new Course("Composition", "ENG-1400", 3, "FA2014"),
    new Course("Making of the Modern Mind 2", "HON-1020", 5, "SP2015"),
    new Course("Calculus 2", "MATH-1720", 5, "SP2015"),
    new Course("Spifo", "BEGE-1720", 3, "SP2015"),
    new Course("Backpacking", "PEAL-1420", 1, "SP2015"),
    new Course("OT Lit", "BEGE-2730", 3, "SU2015"),
    new Course("Speech", "COM-1100", 3, "FA2016"),
    new Course("DataStructs w/ Java", "CS-2210", 3, "FA2016"),
    new Course("Politics & American Culture", "GSS-1100", 3, "FA2016"),
    new Course("Object Oriented Design", "CS-1220", 3, "SP2015"),
    new Course("NT lit", "BTGE-2740", 3, "FA2015"),
    new Course("Chem for Engineers", "CHEM-1050", 3.5, "FA2015"),
    new Course("Operating Systems", "CS-3310", 3, "SP2016"),
    new Course("Foundations of CyberSecurity", "CS-3350", 3, "SP2016")
];

var temp = []
for {
    //TODO: Loop through stuff and pull out the right courses
    }
var planner = new Plan("My Plan","2018","Computer Science","Jesse Richie","SP2017",courses);





var argh;