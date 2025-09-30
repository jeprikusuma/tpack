const owl = $('.owl-carousel');

owl.owlCarousel({
    items:1,
    loop:true,
    margin:20,
    autoplay:true,
    autoplayTimeout:10000,
    autoplayHoverPause:true,
    dots: true,
    smartSpeed: 2000,
    nav: false
});
$('.play').on('click',function(){
    owl.trigger('play.owl.autoplay',[10000])
})
$('.stop').on('click',function(){
    owl.trigger('stop.owl.autoplay')
})