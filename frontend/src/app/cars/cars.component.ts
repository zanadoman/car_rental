import { HttpClient } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { Router } from '@angular/router';
import { Car } from './car.model';
import { environment } from '../../environment/environment';
import { NgFor } from '@angular/common';

@Component({
  selector: 'app-cars',
  standalone: true,
  imports: [NgFor],
  templateUrl: './cars.component.html',
  styleUrl: './cars.component.css'
})
export class CarsComponent {
  private router = inject(Router)
  private httpClient = inject(HttpClient)

  cars: Car[] = []
  selectedCategory = 'all'
  sortedField = 'license'
  filteredCategories: string[] = []
  filteredCars: Car[] = []

  constructor() {
    if (!['customer', 'mechanic', 'salesman', 'admin']
      .includes(sessionStorage.getItem('userRole') || 'visitor')) {
      this.router.navigate([''])
    }
  }

  ngOnInit() {
    this.getCars()
  }

  getCars() {
    console.log('request started')
    this.httpClient.get<Car[]>(
      environment.apiUrl + '/cars',
      { withCredentials: true }
    ).subscribe({
      next: cars => this.cars = cars,
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        console.log(this.cars)
        this.filterCategories()
        this.filterCars()
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
      return this.selectedCategory === 'all' ||
        car.category === this.selectedCategory
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
}
