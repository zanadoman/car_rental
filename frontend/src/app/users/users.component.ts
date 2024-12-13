import { Component, inject } from '@angular/core';
import { DatePipe, NgClass, NgFor, NgIf } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { environment } from '../../environment/environment';
import { User } from './user.model';
import { map } from 'rxjs';
import { CarsComponent } from '../cars/cars.component';
@Component({
  selector: 'app-users',
  standalone: true,
  imports: [ReactiveFormsModule, DatePipe ,NgIf ,NgFor, NgClass],
  templateUrl: './users.component.html',
  styleUrl: './users.component.css'
})
export class UsersComponent {
  router = inject(Router);
  private httpClient = inject(HttpClient)
  private formBuilder = inject(FormBuilder)

  userRole = 'visitor'

  registerUserForm = this.formBuilder.group({
    name: '',
    email: '',
    password: '',
    role: ''
  })


  users: User[] = []
  selectedCategory = 'all'
  sortedField = ''
  filteredCategories: string[] = []
  filteredUsers: User[] = []
  filteredForms = new Map<number, FormGroup>

  constructor() {
    this.userRole = sessionStorage.getItem('userRole') || 'visitor'
      if (this.userRole !== 'admin') {
        this.router.navigate([''])
      }
  }

  ngOnInit() {
    this.getUsers()
  }

  getUsers() {
    console.log('request started')
    this.httpClient.get<User[]>(
      `${environment.apiUrl}/users`,
      { withCredentials: true }
    ).subscribe({
      next: users => {
        console.log(users)
        this.users = users
      },
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.filterForms()
      }
    })
  }

  registerUser() {
    console.log('request started')
    console.log(this.registerUserForm.value)
    this.httpClient.post(
      `${environment.apiUrl}/users`,
      this.registerUserForm.value,
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getUsers()
      }
    })
  }

  activateUser(id: number) {
    console.log('request started')
    console.log(id)
    this.httpClient.patch(
      `${environment.apiUrl}/user/${id}`,
      { active: true },
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getUsers()
      }
    })
  }

  deactivateUser(id: number) {
    console.log('request started')
    console.log(id)
    this.httpClient.patch(
      `${environment.apiUrl}/user/${id}`,
      { active: false },
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getUsers()
      }
    })
  }

  updateUser(id: number) {
    console.log('request started')
    console.log(id)
    console.log(this.filteredForms.get(id)?.value)
    this.httpClient.put(
      `${environment.apiUrl}/user/${id}`,
      this.filteredForms.get(id)?.value,
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getUsers()
      }
    })
  }

  deleteUser(id: number) {
    console.log('request started')
    console.log(id)
    this.httpClient.delete(
      `${environment.apiUrl}/user/${id}`,
      { withCredentials: true }
    ).subscribe({
      next: respone => console.log(respone),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getUsers()
      }
    })
  }

  filterForms() {
    this.filteredForms = new Map(this.users.map(user => {
      return [
        user.id,
        this.formBuilder.group({
          id: user.id,
          name: user.name,
          email: user.email,
          password: user.password,
          role: user.role,
          active: user.active
        })
      ]
    }))
    console.log('forms filtered')
    console.log(this.filteredForms)
  }

}



