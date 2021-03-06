/**
 * Created by Alan on 2/21/2017.
 */
var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

server.listen(8890);
io.on('connection', function (socket) {

    console.log("new client connected");
    var redisClient = redis.createClient();
    redisClient.subscribe('message');
    redisClient.subscribe('update-front');

    redisClient.on("message", function(channel, message) {
        socket.emit(channel, message);
    });
    redisClient.on("update-front", function(channel, update) {
        socket.emit(channel, update);
    });

    socket.on('disconnect', function() {
        redisClient.quit();
    });

});