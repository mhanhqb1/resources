window.GooglePlaceType = window.GooglePlaceType || {};

GooglePlaceType.mobility = [];
GooglePlaceType.mobility.push("airport");
GooglePlaceType.mobility.push("bus_station");
GooglePlaceType.mobility.push("subway");
GooglePlaceType.mobility.push("taxi_stand");
GooglePlaceType.mobility.push("train_station");

GooglePlaceType.car = [];
GooglePlaceType.car.push("gas_station");
GooglePlaceType.car.push("parking");
GooglePlaceType.car.push("car_rental");
GooglePlaceType.car.push("car_repair");
GooglePlaceType.car.push("car_wash");
GooglePlaceType.car.push("car_dealer");

GooglePlaceType.leisure = [];
GooglePlaceType.leisure.push("amusement_park");
GooglePlaceType.leisure.push("aquarium");
GooglePlaceType.leisure.push("art_gallery");
GooglePlaceType.leisure.push("bowling_alley");
GooglePlaceType.leisure.push("campground");
GooglePlaceType.leisure.push("casino");
GooglePlaceType.leisure.push("movie_theater");
GooglePlaceType.leisure.push("rv_park");
GooglePlaceType.leisure.push("spa");
GooglePlaceType.leisure.push("stadium");
GooglePlaceType.leisure.push("zoo");
GooglePlaceType.leisure.push("library");
GooglePlaceType.leisure.push("museum");
GooglePlaceType.leisure.push("park");
GooglePlaceType.leisure.push("lodging");

GooglePlaceType.food = [];
GooglePlaceType.food.push("bakery");
GooglePlaceType.food.push("bar");
GooglePlaceType.food.push("cafe");
GooglePlaceType.food.push("meal_delivery");
GooglePlaceType.food.push("meal_takeawy");
GooglePlaceType.food.push("night_club");
GooglePlaceType.food.push("restaurant");

GooglePlaceType.life = [];
GooglePlaceType.life.push("bank");
GooglePlaceType.life.push("finance");
GooglePlaceType.life.push("insurance_agency");
GooglePlaceType.life.push("real_estate_agency");
GooglePlaceType.life.push("travel_agency");
GooglePlaceType.life.push("laundry");
GooglePlaceType.life.push("post_office");
GooglePlaceType.life.push("synagogue");
GooglePlaceType.life.push("mosque");
GooglePlaceType.life.push("hindu_temple");
GooglePlaceType.life.push("funeral_home");
GooglePlaceType.life.push("church");
GooglePlaceType.life.push("cemetery");

GooglePlaceType.pub = [];
GooglePlaceType.pub.push("city_hall");
GooglePlaceType.pub.push("courthouse");
GooglePlaceType.pub.push("embassy");
GooglePlaceType.pub.push("fire_station");
GooglePlaceType.pub.push("local_government_office");
GooglePlaceType.pub.push("police");
GooglePlaceType.pub.push("school");
GooglePlaceType.pub.push("university");
GooglePlaceType.pub.push("establishment");

GooglePlaceType.wellness = [];
GooglePlaceType.wellness.push("dentist");
GooglePlaceType.wellness.push("doctor");
GooglePlaceType.wellness.push("hospital");
GooglePlaceType.wellness.push("pharmacy");
GooglePlaceType.wellness.push("veterinary_care");
GooglePlaceType.wellness.push("gym");
GooglePlaceType.wellness.push("beauty_salon");
GooglePlaceType.wellness.push("hair_care");
GooglePlaceType.wellness.push("health");

GooglePlaceType.shop = [];
GooglePlaceType.shop.push("bicycle_store");
GooglePlaceType.shop.push("book_store");
GooglePlaceType.shop.push("clothing_store");
GooglePlaceType.shop.push("convenience_store");
GooglePlaceType.shop.push("department_store");
GooglePlaceType.shop.push("electronics_store");
GooglePlaceType.shop.push("florist");
//GooglePlaceType.shop.push("food");
GooglePlaceType.shop.push("furniture_store");
GooglePlaceType.shop.push("grocery_or_supermarket");
GooglePlaceType.shop.push("hardware_store");
GooglePlaceType.shop.push("home_goods_store");
GooglePlaceType.shop.push("jewelry_store");
GooglePlaceType.shop.push("liquor_store");
GooglePlaceType.shop.push("locksmith");
GooglePlaceType.shop.push("movie_rental");
GooglePlaceType.shop.push("pet_store");
GooglePlaceType.shop.push("shoe_store");
GooglePlaceType.shop.push("shopping_mall");
GooglePlaceType.shop.push("store");


GooglePlaceType.getTypeList = function (category) {
    switch (category) {
        case 1:
            return this.mobility.join("|");
        case 2:
            return this.car.join("|");
        case 3:
            return this.leisure.join("|");
        case 4:
            return this.food.join("|");
        case 5:
            return this.life.join("|");
        case 6:
            return this.pub.join("|");
        case 7:
            return this.wellness.join("|");
        case 8:
            return this.shop.join("|");
    }
};

GooglePlaceType.getAll = function () {
    return "".concat(this.getTypeList(1)).concat("|")
            .concat(this.getTypeList(2)).concat("|")
            .concat(this.getTypeList(3)).concat("|")
            .concat(this.getTypeList(4)).concat("|")
            .concat(this.getTypeList(5)).concat("|")
            .concat(this.getTypeList(6)).concat("|")
            .concat(this.getTypeList(7)).concat("|")
            .concat(this.getTypeList(8));
};

GooglePlaceType.getCategoryName = function (category) {
    switch (category) {
        case 1:
            return CATEGORYNAME_MOBILITY;
        case 2:
            return CATEGORYNAME_CAR;
        case 3:
            return CATEGORYNAME_LEISURE;
        case 4:
            return CATEGORYNAME_FOOD;
        case 5:
            return CATEGORYNAME_LIFE;
        case 6:
            return CATEGORYNAME_PUB;
        case 7:
            return CATEGORYNAME_WELLNESS;
        case 8:
            return CATEGORYNAME_SHOP;
    }
    return '';
};
