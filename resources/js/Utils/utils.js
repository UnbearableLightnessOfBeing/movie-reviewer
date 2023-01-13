import { usePage } from '@inertiajs/inertia-vue3';

export function getAvatarSource(name) {
    return 'https://ui-avatars.com/api/?name=' + name + '$color=7F9CF5&background=EBF4FF&rounded=true';
}

export function getImgUrl(urlString) {
    return usePage().props.value.ziggy.url + '/storage/' + urlString.toString();
}

export function getPoster(movie) {
    return movie.poster? getImgUrl(movie.poster) : usePage().props.value.ziggy.url + '/storage/images/posters/no-image.jpg'
}