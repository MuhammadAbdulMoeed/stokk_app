<?php

namespace App\Services\Api;

use Stripe\Stripe;

class StripeService
{
    public $stripe;

    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );
    }

    public function createToken($name, $number, $expiry_month, $expiry_year, $cvc)
    {
        try {
            $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $number,
                    'exp_month' => $expiry_month,
                    'exp_year' => $expiry_year,
                    'cvc' => $cvc,
                ],
            ]);

            $response = ['type' => 'success','message'=>$token->id];
            return  $response;
        } catch (\Stripe\Error\InvalidRequest $e) {
            $response = ['type' => 'error','message'=>$e->getMessage()];
            return  $response;
        } catch (\Stripe\Error\Authentication $e) {
            $response = ['type' => 'error','message'=>$e->getMessage()];
            return  $response;
        } catch (\Stripe\Error\ApiConnection $e) {
            $response = ['type' => 'error','message'=>$e->getMessage()];
            return  $response;
        } catch (\Stripe\Exception\CardException $e) {
            $response = ['type' => 'error','message'=>$e->getError()->message];
            return  $response;
        } catch (Exception $e) {
            $response = ['type' => 'error','message'=>$e->getMessage()];
            return  $response;
        }

    }

    public function charge($amount,$token)
    {
        try {
            $charge = $this->stripe->charges->create([
                'amount' => $amount * 100,
                'currency' => 'usd',
                'source' => $token,
            ]);

            $response = ['type' => 'success','message'=>$charge->id];
            return  $response;
        }
        catch(\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            $response = ['type' => 'error','message'=>$e->getError()->message];
            return  $response;

        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            $response = ['type' => 'error','message'=>$e->getError()->message];
            return  $response;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            $response = ['type' => 'error','message'=>$e->getError()->message];
            return  $response;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $response = ['type' => 'error','message'=>$e->getError()->message];
            return  $response;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            $response = ['type' => 'error','message'=>$e->getError()->message];
            return  $response;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $response = ['type' => 'error','message'=>$e->getError()->message];
            return  $response;
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $response = ['type' => 'error','message'=>$e->getError()->message];
            return  $response;
        }
    }
}
