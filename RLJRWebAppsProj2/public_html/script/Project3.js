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

function Plan(plan_name, catalog_year, major, student_name, current_semester, current_year, courses) {
    this.plan_name = plan_name;
    this.catalog_year = catalog_year;
    this.major = major;
    this.student_name = student_name;
    this.current_semester = current_semester;
    this.current_year = current_year;
    this.courses = courses;
}

function initializeUR() {

    $.getJSON("/~gallaghd/cs3220/termProject/getPlan.php", function (data) {
        var catYear;
        var courseList = [];
        var planner = new Plan("Error", 2014, "Error", "Error", "SP", 2017, courseList);

        $("#plan-name").append(data.student);
        catYear = data.catalogYear;
        $("#plan-term").append(catYear);
        $("#plan-majors").append(data.major);
        $("#plan-IDname").append(data.planName);
        var season;
        if (data.currTerm == "Spring") {
            season = "SP";
        } else if (data.currTerm == "Fall") {
            season = "FA";
        } else { //Summer
            season = "SU";
        }

        //Build courses
        $.each(data.courses, function (index, element) {
            var smester; //not a typo
            if (element.term == "Spring") {
                smester = "SP";
            } else if (element.term == "Fall") {
                smester = "FA";
            } else { //Summer
                smester = "SU";
            }

            var c = new Course(element.name, element.number, element.credits, smester, element.year);
            courseList.push(c);
            var breaker = courseList[0];
            breaker = courseList[1];
            breaker = courseList[2];
            breaker = courseList[3];
            breaker = courseList[4];
            breaker = courseList[5];
            breaker = courseList[6];
            breaker = courseList[7];
            breaker = courseList[8];
            breaker = courseList[9];
            breaker = courseList[10];

        });



        planner = new Plan(data.planName, data.catalogYear, data.major, data.student, season, data.currYear, courseList);



//    var courses = [
//        new Course("C++ Programming", "CS-1210", 2, "FA", 2014),
//        new Course("MOMM Episode 1", "HON-1010", 5, "FA", 2014),
//        new Course("DLD", "EGCP-1010", 3, "FA", 2014),
//        new Course("Calc 1", "MATH-1710", 5, "FA", 2014),
//        new Course("Engineering Profession", "EGGN-1110", 1, "FA", 2014),
//        new Course("Comp", "ENG-1400", 3, "FA", 2014),
//        new Course("MOMM Episode 2", "HON-1020", 5, "SP", 2015),
//        new Course("Calc 2", "MATH-1720", 5, "SP", 2015),
//        new Course("Spifo", "BEGE-1720", 3, "SP", 2015),
//        new Course("Backpacking", "PEAL-1420", 1, "SP", 2015),
//        new Course("Old Testament", "BEGE-2730", 3, "SU", 2015),
//        new Course("Speech", "COM-1100", 3, "FA", 2015),
//        new Course("Java", "CS-2210", 3, "FA", 2015),
//        new Course("Politics & American Culture", "GSS-1100", 3, "FA", 2015),
//        new Course("C++ Object Oriented", "CS-1220", 3, "SP", 2015),
//        new Course("New Testament", "BTGE-2740", 3, "FA", 2015),
//        new Course("Chem for Engineers", "CHEM-1050", 3.5, "FA", 2015),
//        new Course("Operating Systems", "CS-3310", 3, "SP", 2016),
//        new Course("Foundations of Security", "CS-3350", 3, "SP", 2016),
//        new Course("Intro to Bio", "BIO-1000", 3, "SP", 2016),
//        new Course("Discrete Math", "MATH-2510", 3, "SP", 2016),
//        new Course("Gen Physics 1", "PHYS-2110", 4, "SP", 2016),
//        new Course("Theology 1", "BTGE-3755", 3, "FA", 2016),
//        new Course("Algorithms", "CS-3410", 3, "FA", 2016),
//        new Course("Prob & Stats", "MATH-3110", 3, "FA", 2016),
//        new Course("PACL", "PEF-1990", 2, "FA", 2016),
//        new Course("Gen Physics 2", "PHYS-2120", 4, "FA", 2016),
//        new Course("Intro to Graphics", "BRDM-2350", 3, "SP", 2017),
//        new Course("This Class", "CS-3220", 3, "SP", 2017),
//        new Course("A Cool Class", "CS-3510", 3, "SP", 2017),
//        new Course("Databases", "CS-3610", 3, "SP", 2017),
//        new Course("Prinicples of Animation", "BRDM-3630", 3, "SP", 2017),
//        new Course("Senior Seminar", "EGGN-4010", 0, "FA", 2017),
//        new Course("Computer Networks", "EGCP-4310", 3, "FA", 2017),
//        new Course("Computer Graphics", "CS-4710", 3, "FA", 2017),
//        new Course("Senior Design", "CS-4810", 3, "FA", 2017),
//        new Course("Animation Practicum", "BRDM-3765", 1, "FA", 2017),
//        new Course("Cultural Anthropology", "ANTH-1800", 3, "FA", 2017),
//        new Course("Senior Design", "CS-4820", 4, "SP", 2018),
//        new Course("Professional Ethics", "EGGN-3210", 3, "SP", 2018),
//        new Course("Computer Architecture", "EGCP-3210", 3, "SP", 2018),
//        new Course("Theology 2", "BTGE-3765", 3, "SP", 2018),
//        new Course("Intro to Lit", "LIT-2300", 3, "SP", 2018)
//    ];

        planner.years = [];
        for (i = 0; i < courseList.length; i++) {
            var c = courseList[i];
            if (c.semester === "FA" && !(c.year.toString() in planner.years)) {
                planner.years[c.year.toString()] = new Year(c.year);
            } else if ((c.semester === "SP" || c.semester === "SU") &&
                    !(((c.year - 1).toString()) in planner.years)) {
                planner.years[(c.year - 1).toString()] = new Year(c.year - 1);
            }

            var s = c.semester;
            var iden = c.ID;
            if (s === "FA") {
                planner.years[c.year.toString()].fa[iden] = courseList[i];
            } else if (s === "SP") {
                var yr = c.year - 1;
                planner.years[yr.toString()].sp[iden] = courseList[i];
            } else /* SU */ {
                var yr = c.year - 1;
                planner.years[yr.toString()].su[iden] = courseList[i];
            }
        }
        var ur = document.getElementById("UR");
        ur.innerHTML = "";
        var text = "";
        for (var year in planner.years) {
            text += "<div class=\"row\">";

            //FA
            if (year < planner.current_year) {
                text += "<div class=\"semester old\">";
            } else if (year == planner.current_year && planner.current_semester == "FA") {
                text += "<div class=\"semester old\">";
            } else {
                text += "<div class=\"semester\">";
            }
            text += "<div class=\"year\"><p>Fall " + planner.years[year].name.toString() + "<\/p><\/div>";
            for (var cid in planner.years[year].fa) {
                var holder = planner.years[year].fa[cid];
                text += "<div class=\"course\"><div class=\"name\">";
                text += holder.ID + " - ";
                text += holder.name;
                text += "<\/div><div class=\"credits\">";
                text += holder.credits.toString();
                text += "<\/div><\/div>";
            }
            text += "<\/div>"; //semester div

            //SP
            if (year < (planner.current_year)) {
                text += "<div class=\"semester old\">";
            } else if (year == (planner.current_year - 1) && planner.current_semester == "SP") {
                text += "<div class=\"semester old\">";
            } else {
                text += "<div class=\"semester\">";
            }
            text += "<div class=\"year\"><p>Spring " + (planner.years[year].name + 1).toString() + "</p><\/div>";
            for (var cid in planner.years[year].sp) {
                var holder = planner.years[year].sp[cid];
                text += "<div class=\"course\"><div class=\"name\">";
                text += holder.ID + " - ";
                text += holder.name;
                text += "<\/div><div class=\"credits\">";
                text += holder.credits.toString();
                text += "<\/div><\/div>";
            }
            text += "<\/div>"; //semester div

            //SU
            if (year < (planner.current_year - 1)) {
                text += "<div class=\"semester old\">";
            } else if (year == (planner.current_year - 1) && (planner.current_semester == "SU" || planner.current_semester == "FA")) {
                text += "<div class=\"semester old\">";
            } else {
                text += "<div class=\"semester\">";
            }
            text += "<div class=\"year\"><p>Summer " + (planner.years[year].name + 1).toString() + "</p><\/div>";
            for (var cid in planner.years[year].su) {
                var holder = planner.years[year].su[cid];
                text += "<div class=\"course\"><div class=\"name\">";
                text += holder.ID + " - ";
                text += holder.name;
                text += "<\/div><div class=\"credits\">";
                text += holder.credits.toString();
                text += "<\/div><\/div>";
            }
            text += "<\/div>"; //semester div
            text += "<\/div>"; //row div
        }
        ur.innerHTML = text;
    });
}
;
