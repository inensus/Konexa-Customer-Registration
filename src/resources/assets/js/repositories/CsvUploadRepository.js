const resource = '/api/konexa-bulk-register/import-csv'
import Client from './Client/AxiosClient'

export default {
    post (csvData) {
        return Client.post(`${resource}`, csvData)
    },
}
