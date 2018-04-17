function AppRoutes($locationProvider, $urlRouterProvider, $qProvider) {
    // silence unhandled rejections
    $qProvider.errorOnUnhandledRejections(false);

    // remove ! from url
    $locationProvider.hashPrefix('');
    // default route

    $urlRouterProvider.otherwise(function() {
        return '/campaigns';
    });
}

AppRoutes.$inject = ['$locationProvider', '$urlRouterProvider', '$qProvider'];

export default AppRoutes;