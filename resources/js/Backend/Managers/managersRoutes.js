import ManagersDashboard from './Dashboard'

import UsersIndex from './Users/index'
import UsersShow from './Users/show'

import ProjectIndex from './Project/index'
import ProjectCreate from './Project/create'

export default [
    {
        path: '/manage/dashboard',
        component: ManagersDashboard,
        name: 'managers-dashboard'
    },

    {
        path: '/manage/users',
        component: UsersIndex,
        name: 'users-index'
    },

    {
        path: '/manage/users/show/:id',
        component: UsersShow,
        params: true,
        name: 'users-show'
    },

    {
        path: '/manage/projects',
        component: ProjectIndex,
        name: 'projects-index'
    },

    {
        path: '/manage/projects/create',
        component: ProjectCreate,
        name: 'projects-create'
    },
]