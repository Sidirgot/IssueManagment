export default {
     fetchProjects(context, page_url) {
            var page_url = page_url || '/api/projects'
            context.commit('loading_status', true, { root: true })
            axios.get(page_url).then( response => {
                context.commit('loading_status', false, { root: true })
                context.commit('set_projects', response.data.data)
                context.commit('set_pagination', response.data, { root: true })
            })
        },

        fetchTesters(context, project) {
            axios.get(`/api/testers/${project.id}`).then( response => {
                context.commit('set_testers', response.data)
            })
        },

        fetchDevelopers(context, project) {
            axios.get(`/api/developers/${project.id}`).then( response => {
                context.commit('set_developers', response.data)
            })
        },

        createProject(context, project) {
            context.commit('loading_status', true, { root: true })
            return new Promise ((resolve, reject) => {
                axios.post('/api/projects', project).then( response => {
                    resolve(response)
                    context.commit('projects/set_project', response.data, { root: true })
                    context.commit('loading_status', false, { root: true })
                    context.commit('set_flashmessage', {message: 'Project Created Successfully', type: 'success'}, { root: true })
                })
                .catch(error => {
                    reject(response)
                    context.commit('loading_status', false, { root: true })
                    context.commit('set_flashmessage',{bag: error.response.data.errors, type: 'error'}, { root: true })
                })
            })
        },

        updateProject(context, project) {
            context.commit('loading_status', true, { root: true })
            axios.patch(`/api/projects/${project.id}`, project)
                 .then( response => {
                    context.commit('projects/set_project', response.data, { root: true })
                    context.commit('loading_status', false, { root: true })
                    context.commit('set_flashmessage', {message: 'Project Updated Successfully', type: 'success'}, { root: true })
                })
                .catch(error => {
                    context.commit('loading_status', false, { root: true })
                    context.commit('set_flashmessage',{bag: error.response.data.errors, type: 'error'}, { root: true })
                 })
        },

        deleteProject(context, project) {
            context.commit('loading_status', true, { root: true })
            axios.delete(`/api/projects/${project.id}`).then( response => {
                    context.commit('loading_status', false, { root: true })
                    context.commit('set_flashmessage', {message: 'Project Deleted Successfully', type: 'success'}, { root: true })
                })
                .catch(error => {
                    context.commit('loading_status', false, { root: true })
                    context.commit('set_flashmessage',{bag: error.response.data.errors, type: 'error'}, { root: true })
                })
        },

        assignTester(context, {project, tester}) {
            context.commit('loading_status', true, { root: true })
            axios.patch(`/api/add/tester/${project.id}/${tester.id}`)
                 .then( response => {
                    context.commit('projects/set_project', response.data.project, { root: true })
                    context.commit('set_testers', response.data.testers)
                    context.commit('loading_status', false, { root: true })
                    context.commit('set_flashmessage', {message: `${tester.name} Assigned Successfully`, type: 'success'}, { root: true })
                })
                .catch(error => {
                    context.commit('loading_status', false, { root: true })
                    context.commit('set_flashmessage',{bag: error.response.data.errors, type: 'error'}, { root: true })
                 })
        },

        assignDeveloper(context, {project, developer}) {
            context.commit('loading_status', true, { root: true })
            axios.patch(`/api/add/developer/${project.id}/${developer.id}`)
                 .then( response => {
                    context.commit('projects/set_project', response.data.project, { root: true })
                    context.commit('set_developers', response.data.developers)
                    context.commit('loading_status', false, { root: true })
                    context.commit('set_flashmessage', {message: `${developer.name} Assigned Successfully`, type: 'success'}, { root: true })
                })
                .catch(error => {
                    context.commit('loading_status', false, { root: true })
                    context.commit('set_flashmessage',{bag: error.response.data.errors, type: 'error'}, { root: true })
                 })
        },

        removeTester(context, {project, tester}) {
            context.commit('loading_status', true, { root: true })
            axios.patch(`/api/remove/tester/${project.id}/${tester.id}`)
                 .then( response => {
                    context.commit('projects/set_project', response.data.project, { root: true })
                    context.commit('set_testers', response.data.testers)
                    context.commit('loading_status', false, { root: true })
                    context.commit('set_flashmessage', {message: `${tester.name} Removed Successfully`, type: 'success'}, { root: true })
                })
                .catch(error => {
                    context.commit('loading_status', false, { root: true })
                    context.commit('set_flashmessage',{bag: error.response.data.errors, type: 'error'}, { root: true })
                 })
        },

        removeDeveloper(context, {project, developer}) {
            context.commit('loading_status', true, { root: true })
            axios.patch(`/api/remove/developer/${project.id}/${developer.id}`)
                 .then( response => {
                    context.commit('projects/set_project', response.data.project, { root: true })
                    context.commit('set_developers', response.data.developers)
                    context.commit('loading_status', false, { root: true })
                    context.commit('set_flashmessage', {message: `${developer.name} Removed Successfully`, type: 'success'}, { root: true })
                })
                .catch(error => {
                    context.commit('loading_status', false, { root: true })
                    context.commit('set_flashmessage',{bag: error.response.data.errors, type: 'error'}, { root: true })
                 })
        },

        updateStatus(context, {project, status}) {
            context.commit('loading_status', true, { root: true })
            axios.patch(`/api/status/${project.id}/${status}`)
                 .then( response => {
                    context.commit('loading_status', false, { root: true })
                    context.commit('projects/set_project', response.data, { root: true })
                    context.commit('set_flashmessage', {message: `Project ${status} Successfully`, type: 'success'}, { root: true })
                 })
                .catch(error => {
                    context.commit('loading_status', false, { root: true })
                    context.commit('set_flashmessage',{bag: error.response.data.errors, type: 'error'}, { root: true })
                 })
        }
}