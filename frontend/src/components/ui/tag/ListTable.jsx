import React, { useMemo} from 'react';
import useScrollbar from '../../../function/triggers/useScrollbar';
import './ListTable.scss';

// Hằng số cho các class cột
const COLUMN_CLASSES = ['th-center', 'th-num', 'th-short', 'th-text', 'th-long'];

/**
 * Component hiển thị danh sách dạng với các cột tùy chỉnh hỗ trợ đánh số thứ tự.
 * @param {{ value: string, label: string | JSX.Element }[]} options 
 * @param {Object[]} struct - Mảng dữ liệu, mỗi phần tử là một object (struct) đại diện cho một hàng
 * @param {Object} headers - Object chứa key và nhãn của các cột. Không có thì sẽ không có Header. Nếu có thì cần ghi chính xác key với 
 * @param {boolean} isNumbering - Hiển thị cột thứ tự (mặc định false)
 * @param {boolean} isRanking - Nổi bật thứ hạng trong STT, chỉ hoạt động khi có numbering (mặc định false)
 * @param {string} className - Class CSS tùy chỉnh cho bảng
 * @param {string} error - Thông báo lỗi lên bảng (mặc định là không có dữ liệu)
 * @param {string[]} links - Mảng string gồm đường dẫn đến địa chỉ trang web, mặc định là [];
 * 
 * @example
 * ```jsx
 * const data = [
 *   { id: 1, name: "John", age: 30 },
 *   { id: 2, name: "Jane", age: 25 }
 * ];
 * const headers = { name: "Tên", age: "Tuổi" };
 * const links = ['', 'abc.com'];
 * <ListTable struct={data} headers={headers} isNumbering={true} className="my-table" error="Lỗi mất dữ liệu", links={links}/>
 * ```
 */
const ListTable = React.memo(({ struct = [], headers = {}, isNumbering = false, className = "", error = "", links = [], isRanking = false}) => {
  const [hasScrollbar, listRef] = useScrollbar();

  // Kiểm tra dữ liệu đầu vào
  if (!Array.isArray(struct)) {
    console.error("Error: struct must be an array");
    return <div className="error-message">Lỗi: Dữ liệu không hợp lệ</div>;
  }

  // Xác định keys của cột
  const keys = useMemo(
    () => (Object.keys(headers).length > 0 ? Object.keys(headers) : struct.length > 0 && struct[0] ? Object.keys(struct[0]) : []),
    [headers, struct]
  );

  // Hàm xác định chỉ số class cho cột dựa trên giá trị
  const getColumnClass = (value) => {
    if (value === null || value === undefined) return 0; // th-center
    if (typeof value === 'boolean') return 0; // th-center
    if (typeof value === 'number') return value < Math.pow(10, 10) ? 1 : 2; // th-num hoặc th-center
    if (typeof value === 'string') {
      if (value.length < 20) return 2; // th-short
      if (value.length < 60) return 3; // th-text
      return 4; // th-long
    }
    return 0; // th-center
  };

  const getRankingClass = (rank) => {
    if (!isNumbering || !isRanking) return COLUMN_CLASSES[0];
    if (rank < 6) return `${COLUMN_CLASSES[0]} rank-${rank}`;
    return COLUMN_CLASSES[0];
  };

  // Tính toán chỉ số class cho từng cột
  const columnClasses = useMemo(() => {
    const updatedClasses = Array(keys.length).fill(0);
    if (isNumbering) {
      updatedClasses.unshift(0);
    }
    struct.forEach((item) => {
      keys.forEach((key, index) => {
        const newClass = getColumnClass(item[key] ?? null);
        updatedClasses[isNumbering ? index + 1 : index] = Math.max(updatedClasses[isNumbering ? index + 1 : index], newClass);
      });
    });
    return updatedClasses;
  }, [struct, keys, isNumbering]);

  const handleRowClick = (index) => {
    if (links[index]) {
      window.open(links[index], "_blank");
    }
  };

  return (
    <table className={`list-table ${className}`} ref={listRef}>
      {Object.keys(headers).length > 0 && (
        <thead>
          <tr>
            {isNumbering && <th className={COLUMN_CLASSES[0]}>STT</th>}
            {Object.entries(headers).map(([key, label], index) => (
              <th key={key} className={COLUMN_CLASSES[columnClasses[isNumbering ? index + 1 : index]]}
              >{label}</th> 
            ))}
          </tr>
        </thead>
      )}
      <tbody>
        {struct.length > 0 ? (
          struct.map((item, rowIndex) => (
            <tr key={item.id || rowIndex}
              onClick={() => handleRowClick(rowIndex)}
              style={links[rowIndex] ? { cursor: 'pointer' } : {}}>
              {isNumbering && (
                <td className={getRankingClass(rowIndex + 1)}>
                  {isRanking && rowIndex < 3 ? '' : rowIndex + 1 }
                </td>
              )}
              {keys.map((key, colIndex) => (
                <td key={`${rowIndex}-${colIndex}`} className={COLUMN_CLASSES[columnClasses[isNumbering ? colIndex + 1 : colIndex]]}>
                  {item[key] ?? 'N/A'}
                </td>
              ))}
            </tr>
          ))
        ) : (
          <tr>
            <td colSpan={Math.max(1, isNumbering ? keys.length + 1 : keys.length)}>
              {error || "Không có dữ liệu để hiển thị"}
            </td>
          </tr>
        )}
      </tbody>
    </table>
  );
});


export default ListTable;