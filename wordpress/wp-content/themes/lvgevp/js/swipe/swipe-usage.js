function start() {
    let sliders = document.getElementsByClassName('swipe');
    document.swipeSliders = [];

    for (let slider of sliders) {
        document.swipeSliders.push(Swipe(slider));
    }
}

start();
