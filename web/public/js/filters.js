ObjectiveApp.filter('capitalize', function() {
    return function(input, scope) {
        if (input!=null) {
            return input.substring(0,1).toUpperCase()+input.substring(1);
        }
    }
});

ObjectiveApp.filter('html', function($sce) {
	    return function(val) {
	        return $sce.trustAsHtml(val);
	    };
	});

// ObjectiveApp.filter('numberofdays', function() {
//     return function(input, scope) {
//         if (input.done == true) {
//             return 'Done';
//         }
//         var now = new Date();
//         var date = Date.parse(input.dategoal);
//         var diff = (date - now);
//         diff = Math.ceil(diff/(1000 * 3600 * 24));
//         if(diff == 0) { diff = 'Today!';}
//         else
//         if(diff < 0) {diff = 'Too late!';}
//         else { diff = diff+' days left';}
        
//         return diff;
//     }
// });