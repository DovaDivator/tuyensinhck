export const fetchVietnamTime = async (): Promise<Date> => {
    try {
        const res = await fetch('https://timeapi.io/api/Time/current/zone?timeZone=Asia/Ho_Chi_Minh');
        const data = await res.json();
        return new Date(data.dateTime);
    } catch (error) {
        console.error("Lỗi khi lấy giờ Việt Nam:", error);
        return new Date(); // fallback
    }
};