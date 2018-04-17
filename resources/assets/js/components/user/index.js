let userModule = angular.module('app.userModule', []);

import userService from './user.service';
userModule.service('userService', userService);

export default userModule;