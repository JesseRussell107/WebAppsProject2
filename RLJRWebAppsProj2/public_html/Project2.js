/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function Course(name, ID, credits, semester, year) {
    this.name = name;
    this.ID = ID;
    this.credits = credits;
    this.year = year;
    this.semester = semester;
    this.history = false;
}

function Year(name) {
    this.name = name;
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
;

function initialize() {
    var courses = [
        new Course("C++ Programming", "CS-1210", 2, "FA", "2014"),
        new Course("Making of the Modern Mind", "HON-1010", 5, "FA", "2014"),
        new Course("Digital Logic Design", "EGCP-1010", 3, "FA", "2014"),
        new Course("Calculus 1", "MATH-1710", 5, "FA", "2014"),
        new Course("Engineering Profession", "EGGN-1110", 1, "FA", "2014"),
        new Course("Composition", "ENG-1400", 3, "FA", "2014"),
        new Course("Making of the Modern Mind 2", "HON-1020", 5, "SP", "2015"),
        new Course("Calculus 2", "MATH-1720", 5, "SP", "2015"),
        new Course("Spifo", "BEGE-1720", 3, "SP", "2015"),
        new Course("Backpacking", "PEAL-1420", 1, "SP", "2015"),
        new Course("OT Lit", "BEGE-2730", 3, "SU", "2015"),
        new Course("Speech", "COM-1100", 3, "FA", "2016"),
        new Course("DataStructs w/ Java", "CS-2210", 3, "FA", "2016"),
        new Course("Politics & American Culture", "GSS-1100", 3, "FA", "2016"),
        new Course("Object Oriented Design", "CS-1220", 3, "SP", "2015"),
        new Course("NT lit", "BTGE-2740", 3, "FA", "2015"),
        new Course("Chem for Engineers", "CHEM-1050", 3.5, "FA", "2015"),
        new Course("Operating Systems", "CS-3310", 3, "SP", "2016"),
        new Course("Foundations of CyberSecurity", "CS-3350", 3, "SP", "2016")
    ];
    var planner = new Plan("My Plan", new Date().getFullYear(), "Computer Science", "Jesse Richie", "SP2017", courses);
    planner.years = [];
    for (i = 0; i < courses.length; i++) {
        var c = courses[i];
        if (!(c.year in planner.years)) {
            planner.years[c.year] = new Year(c.year);
        }
        var s = c.semester;
        if (s === "FA") {
            var iden = c.ID;
            planner.years[c.year].fa[iden] = courses[i];
        } else if (s === "SP") {
            var iden = c.id;
            planner.years[c.year].sp[iden] = courses[i];
        } else /* SU */ {
            var iden = c.id;
            planner.years[c.year].su[iden] = courses[i];
        }
    }

// needed a break statement
    var argh = 8;
}

initialize();