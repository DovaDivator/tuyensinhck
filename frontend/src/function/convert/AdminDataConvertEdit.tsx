import { useState } from "react";
import Button from "../../views/ui/input/Button";
import * as api from "../../api/AdminEdit";
import { alertFormReact } from "../../alert/alertForm";
import SetMonQuanLyForm from "../../views/alertUI/SetMonQuanLyForm";
import AddTeacherForm from "../../views/alertUI/AddTeacherForm";
import { checkValidSubmitUtils } from "../triggers/checkValidSubmitUtils";
import { ErrorLogProps, DataValidsProps } from "../../types/FormInterfaces";
import { InputValids } from "../../classes/InputValids";
import { hashPassword } from "./hashPassword";
import { alertBasic } from "../../alert/alertBasic";

interface DefaultProps{
  data: any, 
  setData:React.Dispatch<React.SetStateAction<any>>
}

interface UpdateProps extends DefaultProps{
  setIsEdit: React.Dispatch<React.SetStateAction<any>>
}


export const EditThiSinh = (
    {data, setData, setIsEdit} : UpdateProps
) => {
  setData(
    data.map((user: any) => {
          const { link, ...rest } = user;

          return {
            ...rest,
            del: (
              <Button
                type="button"
                icon="fa-solid fa-trash"
                className="btn-cancel"
                title="Loại bỏ thí sinh"
                onClick={async () => {
                  try {
                    const result = await api.deleteThiSinh("102", {
                      id: user.stu_id,
                    });

                    console.log(result);
                    // làm gì đó sau khi thành công
                    setData((prev: any) => prev.filter((u: any) => u.id !== user.id));
                  } catch (error) {
                    console.error("Xóa thất bại", error);
                  }
                }}
              />
            ),
          };
        })
      );
}

export const DefaultThiSinh = (
    {data, setData} : DefaultProps
  ) => {

  setData(
          data.map((user: any) => {
            const {del, ...rest } = user;

            return {
              ...rest,
              link: "https://translate.google.com/?hl=vi&sl=ru&tl=vi&op=translate"
            };
          })
        );
}

export const EditTaiKhoan = (
    {data, setData, setIsEdit} : UpdateProps
) => {
  setData(
    data.map((user: any) => {
          const { link, ...rest } = user;

          return {
            ...rest,
            freeze: (
              <Button
                type="button"
                icon={`fa-solid ${user.isFreeze === "Đang hoạt động" ? "fa-lock" : "fa-unlock"}`}
                className={user.isFreeze === "Đang hoạt động" ? "btn-cancel" : "btn-accept"}
                title={user.isFreeze === "Đang hoạt động" ? "Đình chỉ nguời dùng" : "Kích hoạt trở lại"}
                onClick={async () => {
                  try {
                    const result = await api.setFreeze("102", {
                      id: user.id,
                    });

                    console.log(result);
                    // làm gì đó sau khi thành công
                    setData((prev: any) =>
                      prev.map((u: any) =>
                        u.id === user.id
                          ? {
                              ...u,
                              isFreeze: u.isFreeze === "Đang hoạt động" ? "Bị đình chỉ" : "Đang hoạt động"
                            }
                          : u
                      )
                    );
                    setIsEdit(false);
                    setTimeout(() => setIsEdit(true), 0);
                  } catch (error) {
                    console.error("Freeze thất bại", error);
                  }
                }}
              />
            ),
            removeCd: (
              <Button
                type="button"
                icon="fa-solid fa-person-circle-minus"
                className="btn-cancel"
                disabled={user.isxacthuc === "Chưa xác thực"}
                title={user.isxacthuc === "Chưa xác thực" ? "Không thể chọn" : "Xóa thông tin CCCD"}
                onClick={async () => {
                  try {
                    const result = await api.deleteCccd("102", {
                      id: user.id,
                    });

                    console.log(result);
                    // làm gì đó sau khi thành công
                    setData((prev: any) =>
                      prev.map((u: any) =>
                        u.id === user.id
                          ? {
                              ...u,
                              isxacthuc: false
                            }
                          : u
                      )
                    );
                    setIsEdit(false);
                    setTimeout(() => setIsEdit(true), 0);
                  } catch (error) {
                    console.error("Xóa thất bại", error);
                  }
                }}
              />
            ),
          };
        })
      );
}

export const DefaultTaiKhoan = (
    {data, setData} : DefaultProps
  ) => {

  setData(
          data.map((user: any) => { 
            const { removeCd, freeze, ...rest } = user;

            return {
              ...rest,
              link: "https://translate.google.com/?hl=vi&sl=ru&tl=vi&op=translate"
            };
          })
        );
}

interface UpdateMonGVProps extends UpdateProps{
  listMon: { value: string; label: string }[];
}

export const EditGiaoVien = (
    {data, setData, setIsEdit, listMon} : UpdateMonGVProps
) => {
  setData(
    data.map((user: any) => {
          const { link, ...rest } = user;

          return {
            ...rest,
            freeze: (
              <Button
                type="button"
                icon={`fa-solid ${user.isFreeze === "Đang hoạt động" ? "fa-lock" : "fa-unlock"}`}
                className={user.isFreeze === "Đang hoạt động" ? "btn-cancel" : "btn-accept"}
                title={user.isFreeze === "Đang hoạt động" ? "Đình chỉ nguời dùng" : "Kích hoạt trở lại"}
                onClick={async () => {
                  try {
                    const result = await api.setFreeze("102", {
                      id: user.id,
                    });

                    console.log(result);
                    // làm gì đó sau khi thành công
                    setData((prev: any) =>
                      prev.map((u: any) =>
                        u.id === user.id
                          ? {
                              ...u,
                              isFreeze: u.isFreeze === "Đang hoạt động" ? "Bị đình chỉ" : "Đang hoạt động"
                            }
                          : u
                      )
                    );
                    setIsEdit(false);
                    setTimeout(() => setIsEdit(true), 0);
                  } catch (error) {
                    console.error("Freeze thất bại", error);
                  }
                }}
              />
            ),
            change: (
              <Button
                type="button"
                icon="fa-solid fa-pen"
                title={"Cập nhật môn quản lý"}
                onClick={async () => {
                  const matchedMon = listMon.find(mon => mon.label === user.mon_ql);
                  const defaultValue = matchedMon?.value || "";

                  const resultAlert = await alertFormReact(SetMonQuanLyForm, {
                    listMon,
                    defaultValue,
                  });

                  if (!resultAlert.isConfirmed || resultAlert.value.mon === defaultValue) return;

                  try {
                    const result = await api.updateGVMon("102", {
                      id: user.id,
                      mon: resultAlert.value.mon
                    });

                    console.log(result);
                    // làm gì đó sau khi thành công
                    setData((prev: any) =>
                      prev.map((u: any) =>
                        u.id === user.id
                          ? {
                              ...u,
                              mon_ql: listMon.find(mon => mon.value === resultAlert.value.mon)?.label
                            }
                          : u
                      )
                    );
                    setIsEdit(false);
                    setTimeout(() => setIsEdit(true), 0);
                  } catch (error) {
                    console.error("Freeze thất bại", error);
                  }
                }}
              />
            ),
          };
        })
      );
}

export const DefaultGiaoVien = (
    {data, setData} : DefaultProps
  ) => {

  setData(
          data.map((user: any) => { 
            const { change, freeze, ...rest } = user;

            return {
              ...rest,
              link: "https://translate.google.com/?hl=vi&sl=ru&tl=vi&op=translate"
            };
          })
        );
}

export const addGV = async (listMon: { value: string; label: string }[]) => {
    const valids: DataValidsProps = {
        name: new InputValids({ required: true }),
        email: new InputValids({ required: true, matchType: ['email'] })
    };

    const resultAlert = await alertFormReact(AddTeacherForm, {
        listMon,
    },
    valids
  );

  if (!resultAlert.isConfirmed) return;
    const hashedPassword = await hashPassword('123456a@');
    try {
      const result = await api.addGVtoDB("102", {
          name: resultAlert.value.name,
          mon: resultAlert.value.mon,
          email: resultAlert.value.email,
          phone: resultAlert.value.phone,
          password: hashedPassword
      });

      alertBasic({
         icon: 'success',
         title: 'Thành công',
         message: 'Đã thêm giáo viên vào dữ liệu',
         timer: 5000
      }).then(() => {
        window.location.reload();
      });
                    
      } catch (error) {
        alertBasic({
         title: 'Lỗi',
         message: 'Thêm giáo viên không thành công!',
      })
        console.error("Thêm thất bại", error);
      }
}