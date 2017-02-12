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
initialize();
var planner;
var courses;
courses = [
    new Course("C++ Programming", "CS-1210", 2, "FA", 2014),
    new Course("MOMM Episode 1", "HON-1010", 5, "FA", 2014),
    new Course("DLD", "EGCP-1010", 3, "FA", 2014),
    new Course("Calc 1", "MATH-1710", 5, "FA", 2014),
    new Course("Engineering Profession", "EGGN-1110", 1, "FA", 2014),
    new Course("Comp", "ENG-1400", 3, "FA", 2014),
    new Course("MOMM Episode 2", "HON-1020", 5, "SP", 2015),
    new Course("Calc 2", "MATH-1720", 5, "SP", 2015),
    new Course("Spifo", "BEGE-1720", 3, "SP", 2015),
    new Course("Backpacking", "PEAL-1420", 1, "SP", 2015),
    new Course("Old Testament", "BEGE-2730", 3, "SU", 2015),
    new Course("Speech", "COM-1100", 3, "FA", 2015),
    new Course("Java", "CS-2210", 3, "FA", 2015),
    new Course("Politics & American Culture", "GSS-1100", 3, "FA", 2015),
    new Course("C++ Object Oriented", "CS-1220", 3, "SP", 2015),
    new Course("New Testament", "BTGE-2740", 3, "FA", 2015),
    new Course("Chem for Engineers", "CHEM-1050", 3.5, "FA", 2015),
    new Course("Operating Systems", "CS-3310", 3, "SP", 2016),
    new Course("Foundations of Security", "CS-3350", 3, "SP", 2016),
    new Course("Intro to Bio", "BIO-1000", 3, "SP", 2016),
    new Course("Discrete Math", "MATH-2510", 3, "SP", 2016),
    new Course("Gen Physics 1", "PHYS-2110", 4, "SP", 2016),
    new Course("Theology 1", "BTGE-3755", 3, "FA", 2016),
    new Course("Algorithms", "CS-3410", 3, "FA", 2016),
    new Course("Prob & Stats", "MATH-3110", 3, "FA", 2016),
    new Course("PACL", "PEF-1990", 2, "FA", 2016),
    new Course("Gen Physics 2", "PHYS-2120", 4, "FA", 2016),
    new Course("Intro to Graphics", "BRDM-2350", 3, "SP", 2017),
    new Course("This Class", "CS-3220", 3, "SP", 2017),
    new Course("A Cool Class", "CS-3510", 3, "SP", 2017),
    new Course("Databases", "CS-3610", 3, "SP", 2017),
    new Course("Prinicples of Animation", "BRDM-3630", 3, "SP", 2017),
    new Course("Senior Seminar", "EGGN-4010", 0, "FA", 2017),
    new Course("Computer Networks", "EGCP-4310", 3, "FA", 2017),
    new Course("Computer Graphics", "CS-4710", 3, "FA", 2017),
    new Course("Senior Design", "CS-4810", 3, "FA", 2017),
    new Course("Animation Practicum", "BRDM-3765", 1, "FA", 2017),
    new Course("Cultural Anthropology", "ANTH-1800", 3, "FA", 2017),
    new Course("Senior Design", "CS-4820", 4, "SP", 2018),
    new Course("Professional Ethics", "EGGN-3210", 3, "SP", 2018),
    new Course("Computer Architecture", "EGCP-3210", 3, "SP", 2018),
    new Course("Theology 2", "BTGE-3765", 3, "SP", 2018),
    new Course("Intro to Lit", "LIT-2300", 3, "SP", 2018)
];
function initialize() {

    planner = new Plan("My Plan", 2014, "Computer Science", "Jesse Richie", "SP2017");
    planner.years = [];
    for (i = 0; i < courses.length; i++) {
        var c = courses[i];
        if (c.semester === "FA" && !(c.year.toString() in planner.years)) {
            planner.years[c.year.toString()] = new Year(c.year);
        } else if ((c.semester === "SP" || c.semester === "SU") &&
                !(((c.year - 1).toString()) in planner.years)) {
            planner.years[(c.year - 1).toString()] = new Year(c.year - 1);
        }

        var s = c.semester;
        var iden = c.ID;
        if (s === "FA") {
            planner.years[c.year.toString()].fa[iden] = courses[i];
        } else if (s === "SP") {
            var yr = c.year - 1;
            planner.years[yr.toString()].sp[iden] = courses[i];
        } else /* SU */ {
            var yr = c.year - 1;
            planner.years[yr.toString()].su[iden] = courses[i];
        }
    }
    var text;
    for (var year in planner.years) {
        text = text + "<div class=\"row\"> <div class=\"semester\">";
        text = text + "<div class=\"year\"><p>Fall " + planner.years[year].name.toString() + "</p></div>";
        for (var cid in planner.years[year].fa) {
            var holder = planner.years[year].fa[cid];
            text = text + "<div class=\"course\"><div class=\"name\"";
            text = text + holder.ID + " - ";
            text = text + holder.name;
            text = text + "</div><div class=\"credits\">";
            text = text + holder.credits.toString();
            text = text + "</div></div>";
        }
        text = text + "</div>"; //semester div
        text = text + "<div class=\"semester\">";
        text = text + "<div class=\"year\"><p>Spring " + planner.years[year].name.toString() + "</p></div>";
        for (var cid in planner.years[year].sp) {
            var holder = planner.years[year].sp[cid];
            text = text + "<div class=\"course\"><div class=\"name\"";
            text = text + holder.ID + " - ";
            text = text + holder.name;
            text = text + "</div><div class=\"credits\">";
            text = text + holder.credits.toString();
            text = text + "</div></div>";
        }
        text = text + "</div>"; //semester div
        text = text + "<div class=\"semester\">";
        text = text + "<div class=\"year\"><p>Summer " + planner.years[year].name.toString() + "</p></div>";
        for (var cid in planner.years[year].su) {
            var holder = planner.years[year].su[cid];
            text = text + "<div class=\"course\"><div class=\"name\"";
            text = text + holder.ID + " - ";
            text = text + holder.name;
            text = text + "</div><div class=\"credits\">";
            text = text + holder.credits.toString();
            text = text + "</div></div>";
        }
        text = text + "</div>"; //semester div
        text = text + "</div>"; //row div

        //TODO: Put into UR div
        var UR = document.getElementByID("UR");
        UR.innerHTML = text;
    }
}
;
