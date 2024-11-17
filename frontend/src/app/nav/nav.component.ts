import { HttpClient } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { environment } from '../../environment/environment';
import { Router, RouterLink } from '@angular/router';
import { NgClass, NgIf } from '@angular/common';

@Component({
  selector: 'app-nav',
  standalone: true,
  imports: [RouterLink, NgClass, NgIf],
  templateUrl: './nav.component.html',
  styleUrl: './nav.component.css'
})
export class NavComponent {
  private httpClient = inject(HttpClient)

  router = inject(Router)
  userName: string | null = null

  ngOnInit() {
    this.router.events.subscribe({
      next: () => this.userName = sessionStorage.getItem('userName')
    })
  }

  logout() {
    console.log('request started')
    this.httpClient.post(
      `${environment.apiUrl}/logout`,
      null,
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        sessionStorage.clear()
        this.router.navigate([''])
      }
    })
  }
}
