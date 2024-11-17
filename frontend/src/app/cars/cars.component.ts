import { HttpClient } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { Router } from '@angular/router';
import { Car } from './car.model';
import { environment } from '../../environment/environment';
import { DatePipe, NgFor, NgIf } from '@angular/common';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';

@Component({
  selector: 'app-cars',
  standalone: true,
  imports: [ReactiveFormsModule, DatePipe, NgIf, NgFor],
  templateUrl: './cars.component.html',
  styleUrl: './cars.component.css'
})
export class CarsComponent {
  private router = inject(Router)
  private httpClient = inject(HttpClient)
  private formBuilder = inject(FormBuilder)

  userRole = 'visitor'
  currentDate = new Date

  registerForm = this.formBuilder.group({
    license: '',
    brand: '',
    category: '',
    kilometers: 0,
    dailyfee: 0,
    last_maintenance: 0,
    next_maintenance: 0
  })

  cars: Car[] = []
  selectedCategory = 'all'
  sortedField = 'license'
  filteredCategories: string[] = []
  filteredCars: Car[] = []
  filteredForms = new Map<number, FormGroup>

  constructor() {
    this.userRole = sessionStorage.getItem('userRole') || 'visitor'
    if (!['customer', 'mechanic', 'salesman', 'admin'].includes(this.userRole)) {
      this.router.navigate([''])
    }
  }

  ngOnInit() {
    this.getCars()
  }

  getCars() {
    console.log('request started')
    this.httpClient.get<Car[]>(
      `${environment.apiUrl}/cars`,
      { withCredentials: true }
    ).subscribe({
      next: cars => {
        console.log(cars)
        this.cars = cars
      },
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.filterCategories()
        this.filterCars()
        this.filterForms()
      }
    })
  }

  registerCar() {
    console.log('request started')
    console.log(this.registerForm.value)
    this.httpClient.post(
      `${environment.apiUrl}/cars`,
      this.registerForm.value,
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getCars()
      }
    })
  }

  repairCar(id: number) {
    console.log('request started')
    console.log(id)
    console.log(this.filteredForms.get(id)?.value)
    this.httpClient.patch(
      `${environment.apiUrl}/car/${id}`,
      this.filteredForms.get(id)?.value,
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getCars()
      }
    })
  }

  updateCar(id: number) {
    console.log('request started')
    console.log(id)
    console.log(this.filteredForms.get(id)?.value)
    this.httpClient.put(
      `${environment.apiUrl}/car/${id}`,
      this.filteredForms.get(id)?.value,
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getCars()
      }
    })
  }

  deleteCar(id: number) {
    console.log('request started')
    console.log(id)
    this.httpClient.delete(
      `${environment.apiUrl}/car/${id}`,
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getCars()
      }
    })
  }

  selectCars(event: Event) {
    this.selectedCategory = (event.target as HTMLSelectElement).value
    console.log(`selected category: ${this.selectedCategory}`)
    this.getCars();
  }

  sortCars(event: Event) {
    this.sortedField = (event.target as HTMLSelectElement).value
    console.log(`sorted field: ${this.sortedField}`)
    this.getCars();
  }

  filterCategories() {
    this.filteredCategories = Array.from(
      new Set(this.cars.map(car => car.category))
    ).sort()
    console.log('categories filtered')
    console.log(this.filteredCategories)
  }

  filterCars() {
    this.filteredCars = this.cars.filter(car => {
      return this.selectedCategory === 'all' || car.category === this.selectedCategory
    }).sort((car1, car2) => {
      switch (this.sortedField) {
        case 'license':
          return car1.license.localeCompare(car2.license)
        case 'brand':
          return car1.brand.localeCompare(car2.brand)
        case 'dailyfee':
          return car1.dailyfee - car2.dailyfee
        default:
          return 0
      }
    })
    console.log('cars filtered')
    console.log(this.filteredCars)
  }

  filterForms() {
    this.filteredForms = new Map(this.filteredCars.map(car => {
      return [
        car.id,
        this.formBuilder.group({
          license: car.license,
          brand: car.brand,
          category: car.category,
          kilometers: car.kilometers,
          dailyfee: car.dailyfee,
          last_maintenance: car.last_maintenance,
          next_maintenance: car.next_maintenance
        })
      ]
    }))
  }
}
