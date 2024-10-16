function populateDropdowns() {
    $.ajax({
        url: 'fetch_students.php', // Make sure this is the correct path
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Populate Student ID dropdown
            const studentIDSelect = $('#filterStudentID');
            data.studentID.forEach(function(id) {
                studentIDSelect.append(`<option value="${id}">${id}</option>`);
            });

            // Populate Full Name dropdown
            const fullNameSelect = $('#filterFullName');
            data.fullName.forEach(function(name) {
                fullNameSelect.append(`<option value="${name}">${name}</option>`);
            });

            // Populate Section dropdown
            const sectionSelect = $('#filterSection');
            data.section.forEach(function(section) {
                sectionSelect.append(`<option value="${section}">${section}</option>`);
            });

            // Populate Year Level dropdown
            const yearLevelSelect = $('#filterYearLevel');
            data.yearLevel.forEach(function(year) {
                yearLevelSelect.append(`<option value="${year}">${year}</option>`);
            });

            // Populate Program dropdown
            const programSelect = $('#filterProgram');
            data.program.forEach(function(program) {
                programSelect.append(`<option value="${program}">${program}</option>`);
            });
        }
    });
}
