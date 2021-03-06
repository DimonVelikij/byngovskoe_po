(function (angular) {
    "use strict";

    angular
        .module('content.price-list')
        .controller('PriceListCtrl', PriceListController);

    PriceListController.$inject = [
        '$scope',
        'ProductResource',
        'FilterBuilder',
        'ProductFilterExtension',
        'ProductSortExtension',
        'ProductFilterConfiguration',
        'ProductSortConfiguration',
        '_'
    ];

    function PriceListController (
        $scope,
        ProductResource,
        FilterBuilder,
        ProductFilterExtension,
        ProductSortExtension,
        ProductFilterConfiguration,
        ProductSortConfiguration,
        _
    ) {
        $scope.load = true;

        var filterBuilder = FilterBuilder
            .create()
            .extend({
                filter: ProductFilterExtension,
                sort: ProductSortExtension
            })
            .setFilterConfiguration(ProductFilterConfiguration)
            .addFilterFields(['category', 'unit', 'flour', 'minPrice', 'maxPrice', 'isNew', 'isPopulation'])
            .setSortConfiguration(ProductSortConfiguration)
            .addSortFields(['price']);

        $scope.storage = filterBuilder.createStorage();

        $scope.$on("slideEnded", function(data) {
            var minPrice = data.targetScope.rzSliderModel,
                maxPrice = data.targetScope.rzSliderHigh;

            $scope.storage.filter.minPrice = minPrice;
            $scope.storage.filter.maxPrice = maxPrice;
            $scope.storage.filter.filter().then(function (response) {});
        });
        
        ProductResource.query()
            .then(function (products) {
                $scope.storage.setData(products);
            }, function () {
                $scope.dataLoadError = true;
            })
            .finally(function () {
                $scope.load = false;
            });

        $scope.loadPriceList = function ($event) {
            if ($scope.storage.data.length == $scope.storage.filteredData.length) {
                return;
            }

            var productIds = [];
            _.forEach($scope.storage.filteredData, function (product) {
                productIds.push(product.getId());
            });

            $event.target.setAttribute('href', $event.target.getAttribute('href') + '?product_ids=' + productIds.join(','));
        };
    }

})(angular);