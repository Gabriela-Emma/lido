const blockfrostRequest = async ({
    body = null,
    endpoint = '',
    headers = {},
    method = 'GET'
}) => {
    let networkEndpoint = process.env.NETWORK === '0' ? process.env.PREVIEW_BLOCKFROST_URL : process.env.MAINNET_BLOCKFROST_URL;
    let blockfrostApiKey = process.env.NETWORK === '0' ? process.env.PREVIEW_BLOCKFROST_API_KEY : process.env.MAINNET_BLOCKFROST_API_KEY;

    try {
        return await (
            await fetch(`${networkEndpoint}${endpoint}`, {
                headers: {
                    project_id: blockfrostApiKey,
                    ...headers,
                },
                method,
                body,
            })
        ).json();
    } catch (error) {
        return error;
    }
}

export default blockfrostRequest