$ = jQuery
AgriLife = {} if not AgriLife

AgriLife.Location = class Location

	constructor: (@cookie) ->
		@cookie = {} if not @cookie

		@deferred = $.Deferred()

		if $.isEmptyObject @cookie then @getNewLocation() else @getCookieLocation()

	getNewLocation: () ->
		locator = navigator.geolocation.getCurrentPosition @locationSuccess, @locationError

	getCookieLocation: () ->
		@cookie = JSON.parse @cookie
		console.log @cookie
		@showInfo()

	locationSuccess: (data) =>
		lat = data.coords.latitude
		long = data.coords.longitude
		@getCounty(lat, long)

	locationError: (data) ->
		console.log 'There was an error'

	getCounty: (lat, long) ->
		$.ajax(
			url: 'http://data.fcc.gov/api/block/find'
			data:
				latitude: lat
				longitude: long
				format: 'jsonp'
				showall: false
			dataType: 'jsonp'
			success: (data) =>
				@cookie.lat = lat
				@cookie.long = long
				@cookie.county = data.County.name
				@cookie.state = data.State.name
		).then( (data) =>
			getData =
				action: 'get_units'
			$.ajax(
				url: Ag.ajax_url
				data:
					action: 'get_units'
				success: (units) =>
					office = _.findWhere( JSON.parse(units), { "name": "#{@cookie.county} County Office" } )
					@cookie.phone = office.phone
					@cookie.email = office.email
					@cookie.url = office.url
			)
		).done( (data) =>
			$.cookie 'tamu_ext_location', JSON.stringify(@cookie),
				expires: 7
				path: '/'
			console.log @cookie
		)

	showInfo: () ->
		template = $('script#county-info').html()
		contactInfo = _.template template, @cookie
		$('#county-locator-body').html(contactInfo)
		@deferred.resolve()

do ($ = jQuery) ->
	"use strict"
	$ ->
		agCookie = $.cookie('tamu_ext_location')
		loc = new AgriLife.Location(agCookie)
		loc.deferred.done () =>
			$(document).foundation('reflow')
