function adjustPhotoToView(imgElement) {
    let newMargin = ['0px', '0px', '0px', '0px'];
    let imageHeight = imgElement.offsetHeight;
    let imageWidth = imgElement.offsetWidth;
    var dimensionRatio = imageWidth / imageHeight;

    if (imageHeight < 144) {
        let heightDifference = 144 - imageHeight;
        newMargin[0] = heightDifference / 2 + 'px';
        newMargin[2] = heightDifference / 2 + 'px';
    }

    if (imageHeight > 144) {
        let newWidth = 144 * dimensionRatio;
        imgElement.style.width = newWidth + 'px';

        let widthDifference = 256 - newWidth;
        newMargin[1] = widthDifference / 2 + 'px';
        newMargin[3] = widthDifference / 2 + 'px';
    }

    imgElement.style.margin = newMargin.join(' ');
}

function getViewNewPosition(currentImageIndex, imageCount, direction) {
    if (direction === 'right') {
        var possibleMove = currentImageIndex <= imageCount - 2;
        if (possibleMove) {
            var newPosition = (currentImageIndex + 1) * 16;
            newPosition += 'rem';
        }
    } else if (direction === 'left') {
        var possibleMove = currentImageIndex >= imageCount + 2;
        if (possibleMove) {
            var newPosition = (currentImageIndex + 1) * 16;
            newPosition += 'rem';
        }
    }

    if (possibleMove) {
        return newPosition;
    }

    return false;
}

function removeUnitChars(string) {
    return string.replace(/\D/g, '');
}

function getCurrentViewIndex(viewElement) {
    let viewPosition = viewElement.style.right;
    viewPosition = removeUnitChars(viewPosition);
    viewPosition = parseInt(viewPosition);

    return viewPosition / 16 || 0;
}

function getNextViewIndex(photoView, viewIndex, direction, imageCount) {
    if (direction === 'right') {
        var nextPosition = viewIndex + 1;
        var canMove = (nextPosition < imageCount);
    } else if (direction === 'left') {
        var nextPosition = viewIndex - 1;
        var canMove = (nextPosition >= 0);
    }

    if (canMove) {
        return nextPosition;
    }

    return false;
}

function updateDisplayInfo(galleryElement) {
    let photoView = galleryElement.querySelector(
        '.photo-view-container'
    );

    let currentIndex = getCurrentViewIndex(photoView) + 1;
    let imageCount = galleryElement.getElementsByClassName(
        'photo-container'
    ).length;

    let displayInfoElement = galleryElement.querySelector(
        '.display-information .content'
    );

    displayInfoElement.textContent = currentIndex + '/' + imageCount;
}

function moveView(pressedBtnElement) {
    let galleryElement = pressedBtnElement.parentElement;
    galleryElement = galleryElement.parentElement;
    let btnDirection = pressedBtnElement.className;
    btnDirection = btnDirection.replace('-gallery-btn', '');
    let photoView = galleryElement.querySelector(
        '.photo-view-container'
    );

    let imageCount = galleryElement.getElementsByClassName(
        'photo-container'
    ).length;

    let currentViewIndex = getCurrentViewIndex(photoView);
    let nextViewIndex = getNextViewIndex(
        photoView,
        currentViewIndex,
        btnDirection,
        imageCount
    );

    let nextViewPosition = nextViewIndex * 16 + 'rem';

    if (btnDirection === 'left' && currentViewIndex === 0) {
        nextViewPosition = (imageCount - 1) * 16 + 'rem';
    }

    photoView.style.right = nextViewPosition;
    updateDisplayInfo(galleryElement);
}

function showFullImage(imgElement) {
    let fullImageShowContainer = document.getElementById(
        'full-image-show-container'
    );

    let imageContainer = fullImageShowContainer.getElementsByClassName(
        'content'
    )[0];

    let fullImageURL = imgElement.getAttribute('data-full-image-url');
    let fullImageElement = document.createElement('img');
    fullImageElement.setAttribute('src', fullImageURL);

    imageContainer.innerHTML = '';
    imageContainer.appendChild(fullImageElement);

    let windowHeight = window.innerHeight;
    let windowWidth = window.innerWidth;
    fullImageShowContainer.style.height = windowHeight + 'px';
    fullImageShowContainer.style.width = windowWidth + 'px';
    fullImageShowContainer.style.display = 'flex';
}

function closeFullImageShow() {
    let fullImageShowContainer = document.getElementById(
        'full-image-show-container'
    );

    let imageContainer = fullImageShowContainer.getElementsByClassName(
        'content'
    )[0];

    imageContainer.innerHTML = '';
    fullImageShowContainer.style.display = 'none';
}

function start() {
    let imgLoad = imagesLoaded('.photo-container img');
    imgLoad.on('always', function () {
        let fullImageShowCloseBtn = document.querySelector(
            '#full-image-show-container button'
        );

        fullImageShowCloseBtn.addEventListener('click', closeFullImageShow);

        let imageList = document.querySelectorAll('.photo-container img');
        for (let imageElement of imageList) {
            adjustPhotoToView(imageElement);
            imageElement.addEventListener('click', function () {
                showFullImage(this);
            });
        }

        let galleryList = document.getElementsByClassName(
            'gallery-container'
        );

        for (let gallery of galleryList) {
            updateDisplayInfo(gallery);

            let galleryBtnList = gallery.getElementsByTagName('button');
            for (let galleryBtn of galleryBtnList) {
                galleryBtn.addEventListener('click', function () {
                    moveView(this);
                });
            }
        }
    });
}

start();