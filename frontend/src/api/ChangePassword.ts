interface Unit {
    [key: string]: string;
}

export const ChangePassword = async (token: string, dataToSend: Unit): Promise<any> => {
    try {
        const response = await fetch('http://localhost:8080/api/change-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
            },
            body: JSON.stringify(dataToSend),
            credentials: 'include'   // <-- BẮT BUỘC để gửi JSESSIONID
        });
        const text = await response.text();
        const result = await JSON.parse(text);
        if (!response.ok) {
            const errorJson = {
                status: response.status,
                message: result.message
            };
            console.error(errorJson);
            throw errorJson;
        }
        // console.log('Phản hồi từ servlet:', result);
        return result;

    } catch (error) {
        if (error instanceof TypeError && error.message.includes('Failed to fetch')) {
            throw {
                status: 503,
                message: 'Không thể kết nối đến máy chủ.'
            };
        }
        throw error;
    }
};