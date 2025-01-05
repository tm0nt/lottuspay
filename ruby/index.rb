# Gemfile:
# gem 'faraday'

require 'faraday'
require 'json'

class PineapplePayClient
  BASE_URL = 'https://api.pineapplepay.co'.freeze

  def initialize(client_id, client_secret)
    @client_id = client_id
    @client_secret = client_secret
    @conn = Faraday.new(url: BASE_URL) do |f|
      f.request :url_encoded
      f.adapter Faraday.default_adapter
    end
  end

  # Cria uma nova transação de pagamento
  # Exemplo de data:
  # {
  #   name: "Fulano de Tal",
  #   email: "fulano@example.com",
  #   document: "00000000000",
  #   description: "Serviço X",
  #   amount: 1000,
  #   postbackUrl: "https://minhaurl.com/postback"
  # }
  def create_transaction(data)
    begin
      response = @conn.post do |req|
        req.url '/v1/payment'
        req.headers['Content-Type'] = 'application/json'
        req.headers['x-client-id'] = @client_id
        req.headers['x-client-secret'] = @client_secret
        req.body = data.to_json
      end
      JSON.parse(response.body)
    rescue Faraday::Error => e
      # Trate a exceção de acordo com a necessidade
      nil
    end
  end

  # Estorna uma transação
  # Exemplo de data:
  # {
  #   transactionId: "abc123",
  #   description: "Motivo do estorno"
  # }
  def refund_transaction(data)
    begin
      response = @conn.post do |req|
        req.url '/v1/refund'
        req.headers['Content-Type'] = 'application/json'
        req.headers['x-client-id'] = @client_id
        req.headers['x-client-secret'] = @client_secret
        req.body = data.to_json
      end
      JSON.parse(response.body)
    rescue Faraday::Error => e
      nil
    end
  end

  # Busca uma transação pelo seu ID
  def get_transaction(transaction_id)
    begin
      response = @conn.get do |req|
        req.url "/v1/payment/#{transaction_id}"
        req.headers['Content-Type'] = 'application/json'
        req.headers['x-client-id'] = @client_id
        req.headers['x-client-secret'] = @client_secret
      end
      JSON.parse(response.body)
    rescue Faraday::Error => e
      nil
    end
  end

  # Faz uma transferência (withdraw)
  # Exemplo de data:
  # {
  #   amount: 1000,
  #   name: "Fulano de Tal",
  #   document: "00000000000",
  #   description: "Transferência para Fulano",
  #   key: "fulano@exemplo.com",
  #   keyType: "email"
  # }
  def make_transfer(data)
    begin
      response = @conn.post do |req|
        req.url '/v1/withdraw'
        req.headers['Content-Type'] = 'application/json'
        req.headers['x-client-id'] = @client_id
        req.headers['x-client-secret'] = @client_secret
        req.body = data.to_json
      end
      JSON.parse(response.body)
    rescue Faraday::Error => e
      nil
    end
  end
end
