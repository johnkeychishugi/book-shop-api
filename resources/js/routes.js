const BookList = () => import('./components/book/List.vue' /* webpackChunkName: "resource/js/components/Book/list" */)
const BookEdit = () => import('./components/book/Edit.vue' /* webpackChunkName: "resource/js/components/Book/edit" */)

export const routes = [
    {
        name: 'home',
        path: '/',
        component: BookList
    },
    {
        name: 'BookList',
        path: '/book',
        component: BookList
    },
    {
        name: 'BookEdit',
        path: '/book/:id/edit',
        component: BookEdit
    }
]