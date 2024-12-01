export interface Rent {
  id: number
  user_id: number
  car_id: number
  kilometers: number
  begin: Date
  end: Date
  takeaway: Date
  return: Date
  active: boolean
}
