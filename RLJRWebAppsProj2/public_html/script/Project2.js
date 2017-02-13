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

function initialize() {
    var planner;
    var courses = [
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
    for (var year in planner.years) {
        var row = document.createElement("div");
        row.setAttribute("class", "row");
        //FA
        var fa = document.createElement("div");
        fa.setAttribute("class", "semester");
        var y = document.createElement("div");
        y.setAttribute("class", "year");
        var ytxt = document.createTextNode("Fall " + planner.years[year].name.toString());
        y.appendChild(ytxt);
        fa.appendChild(y);
        for (var cid in planner.years[year].fa) {
            var cou = document.createElement("div");
            cou.setAttribute("class", "name");
            var c = planner.years[year].fa[cid];
            cou.appendChild(document.createTextNode(c.ID + "-" + c.name));

            var cred = document.createElement("div");
            cred.setAttribute("class", "credits");
            cred.appendChild(document.createTextNode(c.credits.toString()));

            fa.appendChild(cou);
            fa.appendChild(cred);
        }
        //SP
        var sp = document.createElement("div");
        sp.setAttribute("class", "semester");
        var y = document.createElement("div");
        y.setAttribute("class", "year");
        var ytxt = document.createTextNode("Spring " + (planner.years[year].name + 1).toString());
        y.appendChild(ytxt);
        sp.appendChild(y);
        for (var cid in planner.years[year].sp) {
            var cou = document.createElement("div");
            cou.setAttribute("class", "name");
            var c = planner.years[year].sp[cid];
            cou.appendChild(document.createTextNode(c.ID + "-" + c.name));

            var cred = document.createElement("div");
            cred.setAttribute("class", "credits");
            cred.appendChild(document.createTextNode(c.credits.toString()));

            sp.appendChild(cou);
            sp.appendChild(cred);
        }
        //SU
        var su = document.createElement("div");
        su.setAttribute("class", "semester");
        var y = document.createElement("div");
        y.setAttribute("class", "year");
        var ytxt = document.createTextNode("Fall " + planner.years[year].name.toString());
        y.appendChild(ytxt);
        su.appendChild(y);
        for (var cid in planner.years[year].su) {
            var cou = document.createElement("div");
            cou.setAttribute("class", "name");
            var c = planner.years[year].su[cid];
            cou.appendChild(document.createTextNode(c.ID + "-" + c.name));

            var cred = document.createElement("div");
            cred.setAttribute("class", "credits");
            cred.appendChild(document.createTextNode(c.credits.toString()));

            su.appendChild(cou);
            su.appendChild(cred);
        }
    }
    document.getElementById("UR");
}

;
initialize();
