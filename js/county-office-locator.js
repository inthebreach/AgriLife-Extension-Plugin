(function() {
  var $, AgriLife, Location,
    __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  $ = jQuery;

  if (!AgriLife) {
    AgriLife = {};
  }

  AgriLife.Location = Location = (function() {
    function Location(cookie) {
      this.cookie = cookie;
      this.locationSuccess = __bind(this.locationSuccess, this);
      if (!this.cookie) {
        this.cookie = {};
      }
      console.log(this.cookie);
      if ($.isEmptyObject(this.cookie)) {
        this.getNewLocation();
      } else {
        this.getCookieLocation();
      }
    }

    Location.prototype.getNewLocation = function() {
      var locator;
      locator = navigator.geolocation.getCurrentPosition(this.locationSuccess, this.locationError);
      return console.log('Getting new location');
    };

    Location.prototype.getCookieLocation = function() {
      this.cookie = JSON.parse(this.cookie);
      console.log('Getting location from cookie');
      return console.log(this.cookie);
    };

    Location.prototype.locationSuccess = function(data) {
      var lat, long;
      lat = data.coords.latitude;
      long = data.coords.longitude;
      return this.getCounty(lat, long);
    };

    Location.prototype.locationError = function(data) {
      return console.log('There was an error');
    };

    Location.prototype.getCounty = function(lat, long) {
      console.log('getting county');
      return $.ajax({
        url: 'http://data.fcc.gov/api/block/find',
        data: {
          latitude: lat,
          longitude: long,
          format: 'jsonp',
          showall: false
        },
        dataType: 'jsonp',
        success: (function(_this) {
          return function(data) {
            _this.cookie.lat = lat;
            _this.cookie.long = long;
            _this.cookie.county = data.County.name;
            _this.cookie.state = data.State.name;
            return console.log(_this.cookie);
          };
        })(this)
      }).then((function(_this) {
        return function(data) {
          var getData;
          getData = {
            action: 'get_units'
          };
          return $.ajax({
            url: Ag.ajax_url,
            data: {
              action: 'get_units'
            },
            success: function(units) {
              var office;
              office = _.findWhere(JSON.parse(units), {
                "name": "" + _this.cookie.county + " County Office"
              });
              _this.cookie.phone = office.phone;
              _this.cookie.email = office.email;
              return _this.cookie.url = office.url;
            }
          });
        };
      })(this)).done((function(_this) {
        return function(data) {
          $.cookie('tamu_ext_location', JSON.stringify(_this.cookie), {
            expires: 7,
            path: '/'
          });
          return console.log(_this.cookie);
        };
      })(this));
    };

    return Location;

  })();

  (function($) {
    "use strict";
    return $(function() {
      var agCookie, loc;
      agCookie = $.cookie('tamu_ext_location');
      return loc = new AgriLife.Location(agCookie);
    });
  })(jQuery);

}).call(this);
