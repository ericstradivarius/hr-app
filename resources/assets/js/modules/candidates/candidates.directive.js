import CandidatesCtrl from './candidates.controller';

class generateInitials {
    constructor() {
        this.restrict = 'E';
        this.controller = CandidatesCtrl;
        this.controllerAs = "$candidatesCtrl";
        this.template = '<canvas width="50" height="50"></canvas>';
        this.scope = {
            initials: '='
        };
        console.log('generate initials from candidates directive');
    }

    link($scope, $elem, $attrs) {


        let colours = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"];

        let name = $scope.initials,
            nameSplit = name.split(" "),
            initials = nameSplit[0].charAt(0).toUpperCase() + nameSplit[1].charAt(0).toUpperCase();

        let charIndex = initials.charCodeAt(0) - 65,
            colourIndex = charIndex % 19;

        let canvas = $elem.find('canvas')[0];
        let context = canvas.getContext("2d");


        let canvasWidth = $(canvas).attr("width"),
            canvasHeight = $(canvas).attr("height"),
            canvasCssWidth = canvasWidth,
            canvasCssHeight = canvasHeight;

        if (window.devicePixelRatio) {
            $(canvas).attr("width", canvasWidth * window.devicePixelRatio);
            $(canvas).attr("height", canvasHeight * window.devicePixelRatio);
            $(canvas).css("width", canvasCssWidth);
            $(canvas).css("height", canvasCssHeight);
            context.scale(window.devicePixelRatio, window.devicePixelRatio);
        }

        context.fillStyle = colours[colourIndex];
        context.fillRect (0, 0, canvas.width, canvas.height);
        context.font = "19px Arial";
        context.textAlign = "center";
        context.fillStyle = "#FFF";
        context.fillText(initials, canvasCssWidth / 2, canvasCssHeight / 1.5);
    }
}

export default generateInitials;

