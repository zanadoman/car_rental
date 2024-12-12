import { DatePipe, NgClass, NgFor, NgIf } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { environment } from '../../environment/environment';
import { Rent } from './rent.model';
import { map } from 'rxjs';
import { CarsComponent } from '../cars/cars.component';
@Component({
  selector: 'app-rents',
  standalone: true,
  imports: [ReactiveFormsModule, DatePipe ,NgIf ,NgFor, NgClass],
  templateUrl: './rents.component.html',
  styleUrl: './rents.component.css'
})
export class RentsComponent {
  router = inject(Router);
  private httpClient = inject(HttpClient)
  private formBuilder = inject(FormBuilder)

  userRole = 'visitor'
  currentDate = new Date

  registerRentForm = this.formBuilder.group({
    user_id: '',
    car_id: '',
    kilometers: 0,
    begin: Date,
    end: Date,
    takeaway: Date,
    return: Date,
    active: false
  })

  rents: Rent[] = []
  selectedCategory = 'all'
  sortedField = ''
  filteredCategories: string[] = []
  filteredRents: Rent[] = []
  filteredForms = new Map<number, FormGroup>

  constructor() {
    this.userRole = sessionStorage.getItem('userRole') || 'visitor'
      if (!['customer', 'mechanic', 'salesman', 'admin'].includes(this.userRole)) {
        this.router.navigate([''])
      }
  }

  ngOnInit() {
    this.getRents()
  }

  getRents() {
    console.log('request started')
    this.httpClient.get<Rent[]>(
      `${environment.apiUrl}/rents`,
      { withCredentials: true }
    ).subscribe({
      next: rents => {
        console.log(rents)
        this.rents = rents
      },
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.filterForms()
      }
    })
  }

  registerRent() {
    console.log('request started')
    console.log(this.registerRentForm.value)
    this.httpClient.post(
      `${environment.apiUrl}/rents`,
      this.registerRentForm.value,
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getRents()
      }
    })
  }

  activateRent(id: number) {
    console.log('request started')
    console.log(id)
    this.httpClient.patch(
      `${environment.apiUrl}/rent/${id}`,
      { active: true },
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getRents()
      }
    })
  }

  deactivateRent(id: number) {
    console.log('request started')
    console.log(id)
    this.httpClient.patch(
      `${environment.apiUrl}/rent/${id}`,
      { active: false },
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getRents()
      }
    })
  }

  takeawayRent(id: number) {
    console.log('request started')
    console.log(this.registerRentForm.value)
    this.httpClient.patch(
      `${environment.apiUrl}/rent/${id}`,
      //this.registerRentForm.value.active ?
       //{ takeaway: new Date().toISOString().split('T')[0] } : {},
       { takeaway: new Date().toISOString().split('T')[0] },
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getRents()
      }
    })
  }

  returnRent(id: number) {
    console.log('request started')
    console.log(this.registerRentForm.value)
    this.httpClient.patch(
      `${environment.apiUrl}/rent/${id}`,
       { return: new Date().toISOString().split('T')[0] },
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getRents()
      }
    })
  }

  updateRent(id: number) {
    console.log('request started')
    console.log(id)
    console.log(this.filteredForms.get(id)?.value)
    this.httpClient.put(
      `${environment.apiUrl}/rent/${id}`,
      this.filteredForms.get(id)?.value,
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getRents()
      }
    })
  }

  deleteRent(id: number) {
    console.log('request started')
    console.log(id)
    this.httpClient.delete(
      `${environment.apiUrl}/rent/${id}`,
      { withCredentials: true }
    ).subscribe({
      next: respone => console.log(respone),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getRents()
      }
    })
  }

  filterForms() {
    this.filteredForms = new Map(this.rents.map(rent => {
      return [
        rent.id,
        this.formBuilder.group({
          user_id: rent.user_id,
          car_id: rent.car_id,
          kilometers: rent.kilometers,
          begin: rent.begin,
          end: rent.end,
          takeaway: rent.takeaway,
          return: rent.return,
          active: rent.active
        })
      ]
    }))
    console.log('forms filtered')
    console.log(this.filteredForms)
  }
}

