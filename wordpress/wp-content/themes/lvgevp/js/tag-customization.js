const CUSTOMIZATION_TABLE = {
    'azul': {
        'target': 'color',
        'value': '#01579B'
    },
    'preto': {
        'target': 'color',
        'value': '#000000'
    },
    'verde': {
        'target': 'color',
        'value': '#1B5E20'
    },
    'vermelho': {
        'target': 'color',
        'value': '#B71C1C'
    },
    'carteira': {
        'target': 'icon',
        'value': 'fas fa-wallet'
    },
    'celular': {
        'target': 'icon',
        'value': 'fas fa-mobile-alt'
    },
    'smartphone': {
        'target': 'icon',
        'value': 'fas fa-mobile-alt'
    }
};

const IRRELEVANT_TAG_CLASSES = ['tag', 'is-normal', 'is-dark'];


function customizeColor(target, value) {
    target.style.color = '#ffffff';
    target.style.background = value;
}


function customizeIcon(target, value) {
    let iconContainer = document.createElement('span');
    iconContainer.className = 'icon';

    let iconElement = document.createElement('i');
    iconElement.className = value;

    iconContainer.appendChild(iconElement);

    target.innerHTML = '';
    target.appendChild(iconContainer);
}


function applyCustomization(tagElement, customizationClass) {
    let options = CUSTOMIZATION_TABLE[customizationClass];
    let target = options['target'];
    let value = options['value'];

    let functions = {
        'color': customizeColor,
        'icon': customizeIcon
    }

    if (functions.hasOwnProperty(target)) {
        let customizationFunction = functions[target];
        customizationFunction(tagElement, value);
    }
}


function getTags(tagsContainer) {
    let tags = tagsContainer.getElementsByClassName('tag');

    return tags;
}


function getClasses(tagElement) {
    let tagClasses = Array.from(tagElement.classList);
    return tagClasses.filter((class_) => {
        return !IRRELEVANT_TAG_CLASSES.includes(class_);
    });
}


function start(tagsContainer) {
    let objectTags = getTags(tagsContainer);

    for (let tagElement of objectTags) {
        let tagClasses = getClasses(tagElement);
        console.log(tagClasses);
        for (let tagClass of tagClasses) {
            if (CUSTOMIZATION_TABLE.hasOwnProperty(tagClass)) {
                applyCustomization(tagElement, tagClass);
            }
        }
    }
}

start(document);
