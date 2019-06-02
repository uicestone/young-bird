function zoom(mask, bigimg, smallimg) {
    this.bigimg = bigimg;
    this.smallimg = smallimg;
    this.mask = mask
}
zoom.prototype = {
    init: function() {
        var that = this;
        this.smallimgClick();
        this.maskClick();
    },
    smallimgClick: function() {
        var that = this;
        $("." + that.smallimg).click(function() {
            $("." + that.bigimg).css({
                height: $("." + that.smallimg).height() * 1.5,
                width: $("." + that.smallimg).width() * 1.5
            });
            $("." + that.mask).css("display","block");
            $("." + that.bigimg).attr("src", $(this).attr("src")).css("display","block")
        })
    },
    maskClick: function() {
        var that = this;
        $("." + that.mask).click(function() {
            $("." + that.bigimg).css("display","none");
            $("." + that.mask).css("display","none")
        })
    },
};