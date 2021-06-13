// alert(stock_symbol);

settings = {
    "async": true,
    "crossDomain": true,
    "url": "https://alpha-vantage.p.rapidapi.com/query?function=GLOBAL_QUOTE&symbol=" + stock_symbol,
    "method": "GET",
    "headers": {
        // Key 1
        "x-rapidapi-key": "ad0a8a9765msh1b5926c788c944bp1067b1jsn7bee43f026fb",
        "x-rapidapi-host": "alpha-vantage.p.rapidapi.com"

        // Key 2
        // "x-rapidapi-key": "5a3404f7a8mshd2cbc50db1c391ap1c24efjsneb9a82cb216d",
        // "x-rapidapi-host": "alpha-vantage.p.rapidapi.com"
    }
};

stock_price = ".stock-price" + (index);

alert(index + " " + stock_price);

$.ajax(settings).done(function(response) {
    console.log(response);

    for (let i = 0; i <= index; i++) {
        // $(".stock-name").append(response["Global Quote"]["01. symbol"]);
        stock_price = ".stock-price" + (i + 1);
        $(stock_price).text(response["Global Quote"]["05. price"]);
    }

});