$(document).ready(function(){
    //select option <-> whos chart shown
    function clickOption(){
        if($('select').val() == 'Chart'){
            $('#ttChart').show();
            $('#bbChart').show();
            $('#yyChart').show();
        }
        else if($('select').val() == 'YY'){
            $('#ttChart').hide();
            $('#bbChart').hide();
            $('#yyChart').show();
        } else if($('select').val() == 'TuTu'){
            $('#yyChart').hide();
            $('#bbChart').hide();
            $('#ttChart').show();
        } else if($('select').val() == 'Ben'){
            $('#yyChart').hide();
            $('#ttChart').hide();
            $('#bbChart').show();
        }
    }
    $('select#chartSelect').change(function(){
        console.log($('select').val());
        clickOption();
    });
    //yy 的饼图
    var yyData = {
            labels: ["assignedYY", "openbyYY", "closebyYY", "assignToYY"],
            datasets: [{
                label: '',
                data: [assignedYY, openbyYY, closebyYY, assignToYY],
                backgroundColor: [
                    '#FF6384',
                    '#4BC0C0',
                    '#FFCE56',
                    '#E7E9ED'
                ],
                borderWidth: 5
            }]
        };


    var ctx = document.getElementById("yyChart");
    var options ={};
    var yyPieChart = new Chart(ctx, {
        type: 'pie',
        data: yyData,
        option: options
    });
    // TT 的饼图
    var ttData = {
            labels: ["assignedTT", "openbyTT", "closebyTT", "assignToTT"],
            datasets: [{
                label: '',
                data: [assignedTT, openbyTT, closebyTT, assignToTT],
                backgroundColor: [
                    '#FF6384',
                    '#4BC0C0',
                    '#FFCE56',
                    '#E7E9ED'
                ],
                borderWidth: 5
            }]
        };


    var ctx = document.getElementById("ttChart");
    var options ={};
    var ttPieChart = new Chart(ctx, {
        type: 'pie',
        data: ttData,
        option: options
    });
    // BB 的饼图
    var bbData = {
            labels: ["assignedBB", "openbyBB", "closebyBB", "assignToBB"],
            datasets: [{
                label: '',
                data: [assignedBB, openbyBB, closebyBB, assignToBB],
                backgroundColor: [
                    '#FF6384',
                    '#4BC0C0',
                    '#FFCE56',
                    '#E7E9ED'
                ],
                borderWidth: 5
            }]
        };


    var ctx = document.getElementById("bbChart");
    var options ={};
    var ttPieChart = new Chart(ctx, {
        type: 'pie',
        data: bbData,
        option: options
    });
});

