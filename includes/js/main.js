import * as THREE from './three.module.min.js';
import { GLTFLoader } from './GLTFLoader.min.js';


let container = document.getElementById('three');
let clientWidth = container.clientWidth;
let clientHeight = container.clientHeight;
let scene = new THREE.Scene();
let renderer = new THREE.WebGLRenderer({antialias: true, alpha: true});
let camera = new THREE.PerspectiveCamera(56, clientWidth / clientHeight, 0.01, 10);
let ambientLight = new THREE.AmbientLight(0xcccccc, 1);
let loader = new GLTFLoader();
let base = new THREE.Group();
let target = new THREE.Vector3();
let mouse = new THREE.Vector2();
let isMobile;
let hamburger = document.getElementById('hamburger');
let header = document.getElementById('header');
let maincontent = document.getElementById('main-content');
let work = document.getElementById('work');
let skills = document.getElementById('skills');
let blogs = document.getElementById('blogs');
let contact = document.getElementById('contact');

if (/Mobi|Android/i.test(navigator.userAgent)) {
    isMobile = true;
} else if (window.innerWidth < 765) {
    isMobile = true;
} else {
    isMobile = false;
}

let three = document.getElementById('three');
let height = window.innerHeight;

if (document.documentElement.scrollTop > height) {
    if (three.classList.contains('small')) {
        
    } else {
        three.classList.toggle('small');
        onWindowResize();
    }
}
window.addEventListener("scroll", function() {
    if (document.documentElement.scrollTop > height) {
        header.classList.add('scroll');
        if (three.classList.contains('small')) {
            return
        } else {
            three.classList.toggle('small');
            onWindowResize();
        }
    } else {
        header.classList.remove('scroll');
        if (three.classList.contains('small')) {
            if (document.documentElement.scrollTop < height) {
                three.classList.toggle('small');
                onWindowResize();
            }
        }
    }
});

document.addEventListener('click', function(e) {
    if (e.target.closest('#nav-work')) {
        work.scrollIntoView();
    }
    if (e.target.closest('#nav-skills')) {
        skills.scrollIntoView();
    }
    if (e.target.closest('#nav-blog')) {
        blogs.scrollIntoView();
    }
    if (e.target.closest('#nav-contact')) {
        contact.scrollIntoView();
    }
    if (e.target.closest('#three')) {
        maincontent.scrollIntoView();
    }
    if (e.target.closest('#bubble-work')) {
        work.scrollIntoView();
    }
    if (e.target.closest('#bubble-skills')) {
        skills.scrollIntoView();
    }
    if (e.target.closest('#bubble-blog')) {
        blogs.scrollIntoView();
    }
    if (e.target.closest('#bubble-contact')) {
        contact.scrollIntoView();
    }
    if (e.target.closest('#down-arrow')) {
        work.scrollIntoView();
    }
    if (e.target.closest('#hamburger')) {
        header.classList.toggle('open');
        hamburger.classList.toggle('toggle');
    }
    if (e.target.closest('.close-notification')) {
        e.target.parentElement.remove();
    }
});

new Typed('#greeting-message', {
    stringsElement: '#greeting-strings',
    loop: true,
    typeSpeed: 31,
    backSpeed: 15,
    backDelay: 3000,
    showCursor: false,
});

init();
animate();
onWindowResize();

function init() {

    scene.add(base);
    scene.add(ambientLight);

    camera.position.set(0,1.94,2);

    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(clientWidth, clientHeight);
    renderer.outputEncoding = THREE.sRGBEncoding;
    
    container.appendChild(renderer.domElement);

    loader.load('./includes/3d/levi.glb', function(gltf) {
        base.add(gltf.scene);
    });
    base.rotation.set(0,-1.2,0);
    window.addEventListener('resize', onWindowResize);
    window.addEventListener("mousemove", onDocumentMouseMove, false);

}

function onDocumentMouseMove(event) {

    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = - (event.clientY / window.innerHeight) * 2 + 1;

}

function onWindowResize() {

    if (/Mobi|Android/i.test(navigator.userAgent)) {
        isMobile = true;
    } else if (window.innerWidth < 765) {
        isMobile = true;
    } else {
        isMobile = false;
        header.classList.remove("open");
        hamburger.classList.remove("toggle");
    }


    let clientWidth = container.clientWidth;
    let clientHeight = container.clientHeight;
    
    camera.aspect = clientWidth / clientHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(clientWidth, clientHeight);

}

function animate() {

    requestAnimationFrame(animate)

    if (isMobile == true) {
        
        base.rotation.y += 0.005;

    } else {

        target.x += ( mouse.x - target.x / 1.5) * .32;
        target.y += ( mouse.y - target.y * 3 ) * .02;
        target.z = camera.position.z;

        base.lookAt(target);
    }
    
    renderer.render(scene, camera)

}