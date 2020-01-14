import ManagersRoutes from './Backend/Managers/managersRoutes'
import dashboard from './Backend/Team/dashboard'
import projects from './Backend/Projects/projects'
import showProject from './Backend/Projects/show-project'
import showIssue from './Backend/Issues/showIssue'

export default {

    mode: 'history',

    routes: [

        ...ManagersRoutes,

        {
            path: '/team/dashboard',
            component: dashboard,
            name: 'team-dashboard'
        },

        {
            path: '/team/projects',
            component: projects,
            name: 'projects'
        },

        {
            path: '/team/project/:id',
            component: showProject,
            params: true,
            name: 'show-project'
        },

        {
            path: '/team/issues/:projectId/:issueId',
            component: showIssue,
            params: true,
            name: 'show-issue'
        }

    ]
}