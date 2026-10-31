@message @message_oksigeniamarandu
Feature: Users get their notifications on their phone, by WhatsApp or Telegram
  In order to get the notifications of the site on my phone
  As a user
  I need to join WhatsApp or Telegram from my notification preferences

  Background:
    Given the following "users" exist:
      | username | firstname | lastname |
      | ana      | Ana       | Prueba   |
    And the following config values are set as admin:
      | phonenumberid  | 1234567890                          | local_oksigeniamarandu |
      | accesstoken    | made-up                             | local_oksigeniamarandu |
      | displayphone   | +34 900 000 000                     | local_oksigeniamarandu |
      | telegramtoken  | made-up                             | local_oksigeniamarandu |
      | telegrambot    | marandu_example_bot                 | local_oksigeniamarandu |
      | telegramnotices | local_oksigeniamarandu/notification | local_oksigeniamarandu |
      | enablednotices | local_oksigeniamarandu/notification | local_oksigeniamarandu |

  @javascript
  Scenario: The settings of the channel tell how to join
    Given I log in as "ana"
    And I visit "/message/notificationpreferences.php"
    When I open the settings of the mobile messaging channel
    Then I should see "reach your phone, by the channel you join"
    And "Join on WhatsApp" "link" should exist
    And "Join on Telegram" "link" should exist

  Scenario: The join link takes the user to the private page of their number
    Given I log in as "ana"
    When I visit "/message/output/oksigeniamarandu/join.php?channel=whatsapp"
    Then I should see "For Ana Prueba"
    And I should see "Scan it with your phone"

  Scenario: The administration says where it is set up and whether it is ready
    Given I log in as "admin"
    When I visit "/admin/settings.php?section=messagesettingoksigeniamarandu"
    Then I should see "Ready: users can join from their notification preferences."
