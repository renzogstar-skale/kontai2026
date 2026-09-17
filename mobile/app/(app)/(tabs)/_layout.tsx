import { Tabs } from 'expo-router';
import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Platform, View, StyleSheet } from 'react-native';

export default function TabLayout() {
  return (
    <Tabs
      screenOptions={{
        headerShown: false,
        tabBarActiveTintColor: '#E6392F', // Fire Red/Orange
        tabBarInactiveTintColor: '#737373', // Muted Text
        tabBarStyle: {
          backgroundColor: '#FFFFFF',
          borderTopWidth: 1,
          borderTopColor: '#F5F5F5',
          position: 'absolute',
          elevation: 16,
          shadowColor: '#000',
          shadowOffset: { width: 0, height: -4 },
          shadowOpacity: 0.04,
          shadowRadius: 12,
          paddingBottom: Platform.OS === 'ios' ? 28 : 12,
          paddingTop: 8,
          minHeight: Platform.OS === 'ios' ? 88 : 70,
        },
        tabBarLabelStyle: {
          fontSize: 11,
          fontWeight: '600',
          marginTop: 2,
        },
      }}>
      <Tabs.Screen
        name="index"
        options={{
          title: 'Home',
          tabBarIcon: ({ color, focused }) => (
            <View style={[styles.iconWrapper, focused && styles.iconWrapperActive]}>
              <MaterialCommunityIcons name={focused ? "home" : "home-outline"} size={26} color={color} />
            </View>
          ),
        }}
      />
      <Tabs.Screen
        name="todays-plan"
        options={{
          title: 'Tasks',
          tabBarIcon: ({ color, focused }) => (
            <View style={styles.iconWrapper}>
              <MaterialCommunityIcons name={focused ? "check-circle" : "check-circle-outline"} size={24} color={color} />
            </View>
          ),
        }}
      />
      <Tabs.Screen
        name="schedule"
        options={{
          title: 'Schedule',
          tabBarIcon: ({ color, focused }) => (
            <View style={styles.iconWrapper}>
              <MaterialCommunityIcons name={focused ? "calendar-month" : "calendar-month-outline"} size={24} color={color} />
            </View>
          ),
        }}
      />
      <Tabs.Screen
        name="your-team"
        options={{
          title: 'Team',
          tabBarIcon: ({ color, focused }) => (
            <View style={styles.iconWrapper}>
              <MaterialCommunityIcons name={focused ? "account-group" : "account-group-outline"} size={24} color={color} />
            </View>
          ),
        }}
      />
      <Tabs.Screen
        name="tools-operations"
        options={{
          title: 'More',
          tabBarIcon: ({ color, focused }) => (
            <View style={styles.iconWrapper}>
              <MaterialCommunityIcons name={focused ? "dots-horizontal-circle" : "dots-horizontal-circle-outline"} size={24} color={color} />
            </View>
          ),
        }}
      />
    </Tabs>
  );
}

const styles = StyleSheet.create({
  iconWrapper: {
    paddingHorizontal: 16,
    paddingVertical: 4,
    borderRadius: 16,
    alignItems: 'center',
    justifyContent: 'center',
  },
  iconWrapperActive: {
    backgroundColor: '#FFF0ED', // Soft warm-orange background
  }
});
